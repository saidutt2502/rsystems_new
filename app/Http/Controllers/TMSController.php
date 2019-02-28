<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use DB;

class TMSController extends Controller
{
    public function deptadmin()
    {
      $depts = DB::table('rs_tms_departments')->where('location_id',session('location'))->select('name','id')
      ->get();
      return view('tms.deptadmin')->withDept($depts);
    }

    public function add_deptadmin(Request $request)
    {

      if($request->dept_selected_dd != '0' ){

            //Deleting
            DB::table('rs_tms_users2dept')->where('dept_id', $request->dept_selected_dd)->where('user_type', '1')->delete();
          if($request->user_list)
          {
          foreach($request->user_list as $each_user){
            DB::table('rs_tms_users2dept')->insert(
            ['user_id' => $each_user, 'dept_id' => $request->dept_selected_dd ,'added_by' => session('user_id'),'user_type' => '1']
             );
          }
  }

      }else{

          $dept_id = DB::table('rs_tms_departments')->insertGetId(
            ['name' =>  $request->department ,'last_edited' => session('user_id'),'location_id' => session('location')]
        );
    
          foreach($request->user_list as $each_user){
            DB::table('rs_tms_users2dept')->insert(
              ['user_id' => $each_user, 'dept_id' => $dept_id ,'added_by' => session('user_id'),'user_type' => '1']
            );
          }
        }
     
        return redirect()->action('TMSController@deptadmin');
    }


    public function add_sup(Request $request)
    {

      if($request->dept_selected_dd != ''){

            //Deleting
            DB::table('rs_tms_users2dept')->where('dept_id', $request->dept_selected_dd)->where('user_type', '2')->delete();
          if($request->user_list)
          {
          foreach($request->user_list as $each_user){
            DB::table('rs_tms_users2dept')->insert(
            ['user_id' => $each_user, 'dept_id' => $request->dept_selected_dd ,'added_by' => session('user_id'),'user_type' => '2']
             );
          }
  }
  
      }
      return redirect()->action('TMSController@sup');
        
    }

    public function sup()
    {
      $depts = DB::table('rs_tms_departments')
      ->join('rs_tms_users2dept','rs_tms_departments.id','=','rs_tms_users2dept.dept_id')
      ->where('rs_tms_departments.location_id',session('location'))
      ->where('rs_tms_users2dept.user_id',session('user_id'))
      ->where('rs_tms_users2dept.user_type','1')
      ->select('rs_tms_departments.name as name','rs_tms_departments.id as id')
      ->get();
      return view('tms.sup')->withDept($depts);
    }

    public function ajax_tms_controller(Request $request)
  {
      if($request->ajax()){

        switch ($request->function_name) {

          case 'get_all_users':
                $users=DB::table('users')
                    ->join('rs_location2users','rs_location2users.user_id','=','users.id')
                    ->where('rs_location2users.location_id',session('location'))
                    ->where('users.user_type_id','1')
                    ->select('users.name as name','users.id as id')
                    ->get();
                    $data=$users;
              break;

          case 'get_user_list':
              $user_prod=DB::table('rs_tms_users2dept')
                   ->join('users','users.id','=','rs_tms_users2dept.user_id')
                  ->where('rs_tms_users2dept.dept_id',$request->dept_id)
                  ->where('rs_tms_users2dept.user_type','1')
                  ->select('users.name as name','users.id as id')
                  ->get();

                  $dept=$request->dept_id;
                  $all_users = DB::table("users") ->select('*')
                  ->join('rs_location2users','rs_location2users.user_id','=','users.id')
                  ->where('users.user_type_id','1')
                  ->where('rs_location2users.location_id',session('location'))
                  ->whereNOTIn('users.id',function($query) use ($dept){
                     $query->select('user_id')
                           ->from('rs_tms_users2dept')
                           ->where('dept_id',$dept)
                           ->where('user_type','2');
                  })
                  ->select('users.name as name','users.id as id')
                  ->get();

                  $data['selected_user']=$user_prod;
                  $data['all_users']=$all_users;
              break;

              case 'get_user_list_sup':
              $user_prod=DB::table('rs_tms_users2dept')
                   ->join('users','users.id','=','rs_tms_users2dept.user_id')
                  ->where('rs_tms_users2dept.dept_id',$request->dept_id)
                  ->where('rs_tms_users2dept.user_type','2')
                  ->select('users.name as name','users.id as id')
                  ->get();


            $dept=$request->dept_id;

            $all_users = DB::table("users") ->select('*')
            ->join('rs_location2users','rs_location2users.user_id','=','users.id')
            ->where('users.user_type_id','1')
            ->where('rs_location2users.location_id',session('location'))
            ->whereNOTIn('users.id',function($query) use ($dept){
               $query->select('user_id')
                     ->from('rs_tms_users2dept')
                     ->where('dept_id',$dept)
                     ->where('user_type','1');
            })
            ->select('users.name as name','users.id as id')
            ->get();

                  $data['selected_user']=$user_prod;
                  $data['all_users']=$all_users;
              break;

            }

          return $data;
      }
  }
}
