<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use DB;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'userLogout']]);
    }

    protected function authenticated($request, $user)
    {

        $user = Auth::user();
        $user_id=$user->id;

        if(DB::table('rs_location2users')->where('user_id', '=',  Auth::id())->where('location_id', '=',  $request->location)->exists()){
            session(['user_id' => Auth::id()]); 
            session(['location' => $request->location]); 
            return redirect()->intended('/home');
        }else{
            Auth::guard('web')->logout();
            return view('auth.access_denied');
        }
       

    }

    public function userLogout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }
}
