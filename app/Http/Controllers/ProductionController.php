<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApprovalTraits;
use DB;
use Session;



class ProductionController extends Controller
{

  
   
    public function index()
    {
      $depts = DB::table('rs_production_dept')->select('department','id')
      ->get();
      return view('production.add_production')->withDept($depts);
    }

    public function settings(Request $request)
    {
      $dept_id = DB::table('rs_production_dept')->insertGetId(
        ['department' =>  $request->department ,'last_edited' => session('user_id')]
    );

    foreach($request->company as $each_company){
      if($each_company != ''){
        DB::table('rs_company_production')->insert(
          ['name' => $each_company, 'dept_id' => $dept_id ,'last_edited' => session('user_id')]
        );
      }
    }

    foreach($request->user_list as $each_user){
      DB::table('rs_users_production')->insert(
        ['user_id' => $each_user, 'production_dept_id' => $dept_id ,'last_edited' => session('user_id')]
      );
    }


    
    }

   


      // Ajax Calls 
  public function ajax_production_controller(Request $request)
  {
      if($request->ajax()){

        switch ($request->function_name) {

          case 'get_all_users':
                $users=DB::table('users')
                    ->join('rs_location2users','rs_location2users.user_id','=','users.id')
                    ->where('rs_location2users.location_id',session('location'))
                    ->select('users.name as name','users.id as id')
                    ->get();
                    $data=$users;
              break;

          case 'get_company_list':
              $company=DB::table('rs_company_production')
              ->where('dept_id',$request->dept_id)
              ->get();
                  $data=$company;
              break;

          case 'get_user_list':
              $user_prod=DB::table('rs_users_production')
                   ->join('users','users.id','=','rs_users_production.user_id')
                  ->where('production_dept_id',$request->dept_id)
                  ->select('users.name as name','users.id as id')
                  ->get();
                  $data=$user_prod;
              break;

            }

          return $data;
      }
  }
  

}