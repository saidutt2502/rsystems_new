<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

use App\Mail\AdminPasswordReset;
use DB;

class AdminLoginController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
      return view('auth.admin-login');
    }

    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:1'
      ]);

      // Attempt to log the user in
      if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {

        // if successful, then redirect to their intended location
        return redirect()->intended(route('admin.dashboard'));
      }

      // if unsuccessful, then redirect back to the login with the form data
      return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }

    public function confirm_reset(Request $request)
    {
      if(DB::table('rs_reset_admin')->where('email', '=', $request->email)->where('random_str', '=', $request->str_random)->where('confirmed', '=',0)->exists()){
        if($request->password == $request->password_confirmation){
              
            DB::table('rs_reset_admin')
                    ->where('email', '=', $request->email)
                    ->where('random_str', '=', $request->str_random)
                    ->where('confirmed', '=',0)
                    ->update(['confirmed' => 1]);

            DB::table('admins')
                ->where('email', $request->email)
                ->update(['password' => bcrypt($request->password)]);
        }

      }
        return view('auth.admin-login');

    }

    public function reset_password(Request $request)
    {

      if(DB::table('admins')->where('email', '=', $request->email)->exists()){

              $random_str = Str::random(16);
              $url = "/admin/reset-password";

              DB::table('rs_reset_admin')->insert([
                'email' => $request->email, 'random_str' => $random_str
              ]);

              $mailData = array(
                'randomStr' => $random_str,
                'url'     => $url,
            );

              \Mail::to($request->email)->queue(new AdminPasswordReset($mailData));
        }
          return view('auth.admin-login');
    }
}
