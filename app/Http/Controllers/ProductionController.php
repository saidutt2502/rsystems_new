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

    public function edit_production()
    {     
      return view('production.edit_production');
    }

    public function edit_production_form(Request $request)
    {     
       
        if(is_array($request->user_list)){

        //Deleting
        DB::table('rs_production_user_list')->where('location_id', session('location'))->delete();

        foreach($request->user_list as $each_user){
          DB::table('rs_production_user_list')->insert(
            ['user_id' => $each_user,'location_id' => session('location'),'last_edited' => session('user_id')]
          );
        }
      }else{
        //Deleting
        DB::table('rs_production_user_list')->where('location_id', session('location'))->delete();
      }

      return redirect()->action('ProductionController@edit_production');
    }

    public function settings(Request $request)
    {

      if($request->dept_selected_dd != '0' ){

        //Deleting
            DB::table('rs_company_production')->where('dept_id', $request->dept_selected_dd)->delete();

        foreach($request->company as $each_company){
          if($each_company != ''){
            DB::table('rs_company_production')->insert(
              ['name' => $each_company, 'dept_id' => $request->dept_selected_dd ,'last_edited' => session('user_id')]
            );
          }
        }
    
            //Deleting
            DB::table('rs_users_production')->where('production_dept_id', $request->dept_selected_dd)->delete();

          foreach($request->user_list as $each_user){
            DB::table('rs_users_production')->insert(
              ['user_id' => $each_user, 'production_dept_id' => $request->dept_selected_dd ,'last_edited' => session('user_id')]
            );
          }

      }else{

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
     
        return redirect()->action('ProductionController@index');
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

              $all_users=DB::table('users')
                  ->join('rs_location2users','rs_location2users.user_id','=','users.id')
                  ->where('rs_location2users.location_id',session('location'))
                  ->select('users.name as name','users.id as id')
                  ->get();

                  $data['selected_user']=$user_prod;
                  $data['all_users']=$all_users;
              break;

          case 'get_edit_list':
              $user_prod=DB::table('rs_production_user_list')
                  ->join('users','users.id','=','rs_production_user_list.user_id')
                  ->where('rs_production_user_list.location_id',session('location'))
                  ->select('users.name as name','users.id as id')
                  ->get();

              $all_users=DB::table('users')
                  ->join('rs_location2users','rs_location2users.user_id','=','users.id')
                  ->where('rs_location2users.location_id',session('location'))
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