<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\rs_tms_users2dept;
use App\rs_tms_workstations;
use App\rs_tms_lines;
use App\rs_tms_products;
use App\rs_tms_tools;

use Session;
use DB;

class TMSController extends Controller
{
    public function deptadmin()
    {
      $depts = DB::table('rs_tms_departments')->where('location_id',session('location'))->select('name','id')->whereNull('deleted_at')
      ->get();
      return view('tms.deptadmin')->withDept($depts);
    }

    public function add_deptadmin(Request $request)
    {

      if($request->dept_selected_dd != '0' ){

            //Deleting
            rs_tms_users2dept::where('dept_id', $request->dept_selected_dd)->where('user_type', '1')->delete();
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
            rs_tms_users2dept::where('dept_id', $request->dept_selected_dd)->where('user_type', '2')->delete();
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

    public function wlp()
    {
      $depts = DB::table('rs_tms_departments')
      ->join('rs_tms_users2dept','rs_tms_departments.id','=','rs_tms_users2dept.dept_id')
      ->where('rs_tms_departments.location_id',session('location'))
      ->where('rs_tms_users2dept.user_id',session('user_id'))
      ->where('rs_tms_users2dept.user_type','1')
      ->select('rs_tms_departments.name as name','rs_tms_departments.id as id')
      ->get();
      return view('tms.wlp')->withDept($depts);
    }

    public function add_wlp(Request $request)
    {

      if($request->dept_selected_dd){

        //Deleting
            rs_tms_workstations::where('dept_id', $request->dept_selected_dd)->delete();
            rs_tms_lines::where('dept_id', $request->dept_selected_dd)->delete();
            rs_tms_products::where('dept_id', $request->dept_selected_dd)->delete();
   
        if($request->wk)
        {
        foreach($request->wk as $each_company){
          if($each_company != ''){
            DB::table('rs_tms_workstations')->insert(
              ['name' => $each_company, 'dept_id' => $request->dept_selected_dd ,'added_by' => session('user_id')]
            );
          }
        }
        }

        if($request->lines)
        {
        foreach($request->lines as $each_company){
            if($each_company != ''){
              DB::table('rs_tms_lines')->insert(
                ['name' => $each_company, 'dept_id' => $request->dept_selected_dd ,'added_by' => session('user_id')]
              );
            }
          }
        }  

        if($request->products)
        {
        foreach($request->products as $each_company){
            if($each_company != ''){
              DB::table('rs_tms_products')->insert(
                ['name' => $each_company, 'dept_id' => $request->dept_selected_dd ,'added_by' => session('user_id')]
              );
            }
          }
        }    

      }
     
        return redirect()->action('TMSController@wlp');
    }

    public function select_dept()
    {
      $depts = DB::table('rs_tms_departments')
      ->join('rs_tms_users2dept','rs_tms_departments.id','=','rs_tms_users2dept.dept_id')
      ->where('rs_tms_departments.location_id',session('location'))
      ->where('rs_tms_users2dept.user_id',session('user_id'))
      ->where('rs_tms_users2dept.user_type','1')
      ->select('rs_tms_departments.name as name','rs_tms_departments.id as id')
      ->get();
      return view('tms.select_dept')->withDepts($depts);
    }

    public function tools()
    {
        $items = DB::table('rs_tms_tools')
                    ->where('dept_id',session('TMS_DEPT_ID'))
                    ->get();

        return view('tms.tools')->withItem($items);
    }

    public function ajax_tms_controller(Request $request)
  {
      if($request->ajax()){

        switch ($request->function_name) {

          case 'get_dept_session':
            $data = session('TMS_DEPT_ID');
          break;

          case 'set_dept_session':
            session(['TMS_DEPT_ID' => $request->dept_id]); 
            $data = session('TMS_DEPT_ID');
          break;

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

              case 'get_wk_list':
              $company=DB::table('rs_tms_workstations')
              ->where('dept_id',$request->dept_id)
              ->get();
                  $data=$company;
              break;

              case 'get_lines_list':
              $company=DB::table('rs_tms_lines')
              ->where('dept_id',$request->dept_id)
              ->get();
                  $data=$company;
              break;

              case 'get_products_list':
              $company=DB::table('rs_tms_products')
              ->where('dept_id',$request->dept_id)
              ->get();
                  $data=$company;
              break;

              case 'add_tool':
              if($request->location)
              {
                $id = DB::table('rs_tms_tools')->insertGetId([
                    'tool_code' => $request->code, 
                    'name' => $request->name,
                    'tool_location'=> $request->location,
                    'tool_limit' => $request->threshold,
                    'dept_id' =>session('TMS_DEPT_ID'),
                    'added_by' =>session('user_id') ,
                    'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
              ]);
              }
              else
              {
                $id = DB::table('rs_tms_tools')->insertGetId([
                    'tool_code' => $request->code, 
                    'name' => $request->name,
                    'tool_limit' => $request->threshold,
                    'dept_id' =>session('TMS_DEPT_ID'),
                    'added_by' =>session('user_id') ,
                    'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
              ]);
              }
                
                 $data['insert_id'] = $id;
                 break;
               case 'delete_tool':
                 rs_tms_tools::where('id', $request->id)->delete();
                 $data=1;
                  break;

               case 'update_stock':
                                
                  foreach($request->id as $key => $value){
                      DB::table('rs_tms_tools')
                              ->where('id', $value)
                              ->increment('available',$request->qty[$key],['added_by' =>session('user_id'),'updated_at'=> DB::raw('CURRENT_TIMESTAMP')]);
                      
                      DB::table('rs_tms_stockupdate')->insertGetId([
                                  'tool_id' => $value, 
                                  'user_id' => session('user_id'),
                                  'dept_id' => session('TMS_DEPT_ID'),
                                  'quantity'=> $request->qty[$key],
                                  'updated_at' =>  DB::raw('CURRENT_TIMESTAMP')
                            ]);
                      }
                   $data=1;
                   break;
                   
               case 'update_item':
               if($request->location)
               {
                DB::table('rs_tms_tools')
                ->where('id', $request->id)
                ->update([
                    'tool_code' => $request->code, 
                    'name' => $request->name,
                    'tool_location'=> $request->location,
                    'available'=> $request->available,
                    'tool_limit' => $request->threshold,
                    'dept_id' =>session('TMS_DEPT_ID'),
                    'added_by' =>session('user_id') ,
                ]);
               }
               else
               {
                DB::table('rs_tms_tools')
                ->where('id', $request->id)
                ->update([
                    'tool_code' => $request->code, 
                    'name' => $request->name,
                    'available'=> $request->available,
                    'tool_limit' => $request->threshold,
                    'dept_id' =>session('TMS_DEPT_ID'),
                    'added_by' =>session('user_id') ,
                ]);
               }
              $data=1;  

                break;    

               default:
                  $data['success'] = 'false';           

            }

          return $data;
      }
  }
}
