<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use App\rs_locations;
use App\rs_holiday_calender;
use App\rs_location2department;
use App\rs_location2users;
use App\rs_costcenters;
use App\rs_reporting;
use App\rs_cc2modules;



class StepController extends Controller
{


  public function step_1()
  {
     $location = DB::table('rs_locations')
     ->leftJoin('rs_location2department', 'rs_location2department.location', '=', 'rs_locations.id')
     ->select('rs_locations.*', DB::raw("count(rs_location2department.location) as count"))
     ->groupBy('rs_locations.id')
     ->get();

     $dept2location = DB::table('rs_departments')->select('rs_departments.name as name','rs_departments.id as id','rs_location2department.location as location_id') 
                  ->join('rs_location2department', 'rs_location2department.department', '=', 'rs_departments.id')
                  ->get();

    return view('admin.step_1')->withLocation($location)->withDeptlocation($dept2location);
  }

  public function step_2()
  {
    $location = DB::table('rs_locations')
    ->leftJoin('rs_location2users', 'rs_location2users.location_id', '=', 'rs_locations.id')
    ->select('rs_locations.*', DB::raw("count(DISTINCT rs_location2users.user_id) as count"))
    ->groupBy('rs_locations.id')
    ->get();
    return view('admin.step_2')->withLocation($location);
  }

  public function step_3()
  {
    $location = DB::table('rs_locations')
    ->leftJoin('rs_location2department', 'rs_location2department.location', '=', 'rs_locations.id')
    ->select('rs_locations.*', DB::raw("count(rs_location2department.location) as count"))
    ->groupBy('rs_locations.id')
    ->get();

    $dept2location = DB::table('rs_departments')->select('rs_departments.name as name','rs_departments.id as id','rs_location2department.location as location_id','rs_departments.hod_id as hod_id') 
                 ->join('rs_location2department', 'rs_location2department.department', '=', 'rs_departments.id')
                 ->get();

  

  


   return view('admin.step_3')->withLocation($location)->withDeptlocation($dept2location);
  }

  public function location_user($id)
  {
    $location = DB::table('rs_locations')->where('id', $id)->value('name');
    $users = DB::table('users')
            ->select('users.*')
            ->join('rs_location2users', 'users.id', '=', 'rs_location2users.user_id')
            ->join('rs_locations', 'rs_locations.id', '=', 'rs_location2users.location_id')
            ->where('rs_location2users.location_id',$id)
            ->distinct()
            ->get();

    return view('admin.location_user')->withId($id)->withName($location)->withUsers($users);
  }

  public function location_user1($id)
  {
    $location = DB::table('rs_locations')->where('id', $id)->value('name');
    $departments = DB::table('rs_departments')
            ->select('rs_departments.*')
            ->join('rs_location2department', 'rs_departments.id', '=', 'rs_location2department.department')
            ->where('rs_location2department.location',$id)
            ->get();
    $users = DB::table('users')->get();        

    return view('admin.department_hod')->withId($id)->withName($location)->withDepartments($departments)->withUsers($users);
  }


  //HOD Admin Functions


  //OC
  public function oc()
  {
    $admins = DB::table('admins')->where('id',session('admin_id'))->value('email');
    $users = DB::table('users')->where('email',$admins)->value('id');
    $department = DB::table('rs_departments')->where('hod_id',$users)->get();
    return view('admin.oc_details')->withDepartments($department);
  }

  public function oc_structure()
  {
    $department = DB::table('rs_departments')
                 ->join('rs_location2department','rs_location2department.department','=','rs_departments.id')
                 ->join('rs_locations','rs_locations.id','=','rs_location2department.location')
                 ->where('rs_departments.hod_id',session('user_id'))
                 ->where('rs_locations.id',session('location'))
                 ->select('rs_departments.*','rs_locations.name as l_name')
                 ->get();
    return view('admin.oc_structure')->withDepartments($department)->withHodid(session('user_id'));
  }

  public function oc_structure_1(Request $request)
  {
     $d_name = DB::table('rs_departments')->where('id',$request->dept_id)->value('name');
     $l_name = DB::table('rs_location2department')
     ->join('rs_locations','rs_locations.id','=','rs_location2department.location')
     ->where('rs_location2department.department',$request->dept_id)
     ->select('rs_locations.name','rs_locations.id as l_id')
     ->first();
    
     $user_list = DB::table('users')
     ->join('rs_location2users','rs_location2users.user_id','=','users.id')
     ->where('rs_location2users.location_id',$l_name->l_id)
     ->select('users.name','users.id','users.emp_id')
     ->get();

     if($request->level_selected=='2')
     {
      $hierarchy = DB::table('rs_reporting')
      ->join('users','users.id','=','rs_reporting.reportee')
      ->where('rs_reporting.department',$request->dept_id)
      ->where('rs_reporting.level',$request->level_selected)
      ->select('users.name','users.emp_id','users.id','rs_reporting.id as r_id')
      ->get();
      

      return view('admin.oc_structure_line2')->withDepartments($request->dept_id)
      ->withDeptname($d_name)->withHodid(session('user_id'))->withHierarchies($hierarchy)
      ->withLevel($request->level_selected)->withUsers($user_list)->withLocation($l_name);
     }
     else
     {
      $previous_line = DB::table('rs_reporting')
      ->join('users','users.id','=','rs_reporting.reportee')
      ->where('rs_reporting.department',$request->dept_id)
      ->where('rs_reporting.level',$request->level_selected-1)
      ->select('users.name','users.emp_id','users.id')
      ->get();

     


      return view('admin.oc_structure_lines')->withDepartments($request->dept_id)
      ->withDeptname($d_name)->withPreviouslines($previous_line)->withLevel($request->level_selected)->withUsers($user_list)->withLocation($l_name);
     }
  }

  //Cost Center

  public function hod_cc()
  {
    $department = DB::table('rs_departments')
                 ->join('rs_location2department','rs_location2department.department','=','rs_departments.id')
                 ->join('rs_locations','rs_locations.id','=','rs_location2department.location')
                 ->where('rs_departments.hod_id',session('user_id'))
                 ->where('rs_locations.id',session('location'))
                 ->select('rs_departments.*','rs_locations.name as l_name')
                 ->get();
    return view('admin.hod_cc')->withDepartments($department);
  }

  public function hod_cc_allocation()
  {

    $user_list = DB::table('rs_reporting')
    ->join('users','users.id','=','rs_reporting.reportee')
    ->join('rs_location2users','rs_location2users.user_id','=','users.id')
    ->where('reporter',session('user_id'))
    ->where('rs_location2users.location_id',session('location'))
    ->select('users.name','users.emp_id','users.id','rs_location2users.location_id as location')
    ->get();
               
    return view('admin.hod_cc_allocation')->withUsers($user_list)->withHod(session('user_id'));
  }

  public function assign_module_admins()
  {
    $users = session('user_id');
    $department = DB::table('rs_departments')
                 ->join('rs_location2department','rs_location2department.department','=','rs_departments.id')
                 ->join('rs_locations','rs_locations.id','=','rs_location2department.location')
                 ->where('rs_departments.hod_id',session('user_id'))
                 ->where('rs_locations.id',session('location'))
                 ->select('rs_departments.*','rs_locations.name as l_name','rs_locations.id as l_id')
                 ->get();

    

    $assigned_admins = DB::table('rs_admin2modules')->get();

    return view('admin.admin_module_assign')->withDepartments($department)->withUsers($users)->withAdmins($assigned_admins);
  }

//Holiday Calender
  public function calender_locations()
  {
    $location = DB::table('rs_locations')
    ->leftJoin('rs_location2users', 'rs_location2users.location_id', '=', 'rs_locations.id')
    ->select('rs_locations.*', DB::raw("count(DISTINCT rs_location2users.user_id) as count"))
    ->groupBy('rs_locations.id')
    ->get();
    return view('admin.calender_locations')->withLocation($location);
  }

  public function calender($id)
  {
    $location = DB::table('rs_locations')->where('id', $id)->value('name');

    $check_table= DB::table('rs_holiday_calender')->where('location_id',$id)->get();
    $count= DB::table('rs_holiday_calender')->where('location_id',$id)->count('location_id');

    return view('admin.calender')->withId($id)->withName($location)->withExist($check_table)->withCount($count);
  }

  public function calender_function(Request $request)
  {
  
    rs_holiday_calender::where('location_id', '=', $request->location_id)->delete();
    for($i=0;$i<sizeof($request->holiday_name);$i++)
    {
      $id = DB::table('rs_holiday_calender')->insert([
        'holiday_name' =>  $request->holiday_name[$i],
        'holiday_date' =>  $request->holiday_date[$i],
        'location_id' =>  $request->location_id,
        'updated_by' => session('admin_id'),
    ]);
    }
    return redirect()->action('Admin\StepController@calender', ['id'=> $request->location_id]); 
    
  }


  // Ajax Calls 
  public function ajax_step_controller(Request $request)
  {
    $data = array("success"=>"true","insert_id"=>"0","data"=>"","msg"=>"");

      if($request->ajax()){

        switch ($request->function_name) {

          case 'add_location':
                $id = DB::table('rs_locations')->insertGetId([
                    'name' =>  $request->name,
                     'last_edited' => session('admin_id'),
                 ]);
                 $data['insert_id'] = $id;
                 break;

          case 'del_location':
                rs_locations::where('id', '=', $request->id)->delete();
                rs_location2department::where('location', '=', $request->id)->delete();
                 break;
                 
          case 'add_department':
          
          //Adding entry to Departments table
          $id = DB::table('rs_departments')->insertGetId([
            'name' => $request->name,
            'last_edited' => session('admin_id')
            ]);

                //Adding entry to rs_location2department
                 DB::table('rs_location2department')->insert([
                   'department' => $id,
                   'location' => $request->location_id,
                   'last_edited' => session('admin_id')
                   ]);

                   $data['insert_id'] = $id;
                   break;

            case 'del_department':
                  rs_departments::where('id', '=', $request->id)->delete();
                  rs_location2department::where('department', '=', $request->id)->delete();
                  break;

            case 'list_departments':
                  $dept2location = DB::table('rs_departments')->select('rs_departments.name as name','rs_departments.id as id') 
                  ->join('rs_location2department', 'rs_location2department.department', '=', 'rs_departments.id')
                  ->where('rs_location2department.location', '=', $request->id)
                  ->get();

                  $data['data'] = $dept2location;
                  break;
            
              case 'get_list_user':
                  $users=DB::table('users')->get();
                  return $users;
                  break;

              case 'autocomplete_user':
                  $users=DB::table('users')->where('emp_id',$request->emp_id)->get();
                  return $users;
                  break;

            case 'delete_user':
                  rs_location2users::where('user_id', $request->user_id)->delete();
                  break;

            case 'add_user':
                   $check=DB::table('users')->where('emp_id',$request->emp_id)->first();
                   if($check)
                   {
                       $inserted_user = $check->id;
                       DB::table('rs_location2users')->insert(
                        ['user_id' => $inserted_user, 'location_id' => $request->loc_id,'last_edited' => session('admin_id') ]
                     );
                   }
                   else{
                   $inserted_user = DB::table('users')->insertGetId([

                            'name' => $request->name, 
                            'email' => $request->email,
                            'password'=> bcrypt($request->password),
                            'emp_id' => $request->emp_id,
                            'user_type_id' => $request->user_type_id 

                      ]);
                    
                      DB::table('rs_location2users')->insert(
                           ['user_id' => $inserted_user, 'location_id' => $request->loc_id,'last_edited' => session('admin_id') ]
                        );
                      }

                        $data['insert_id'] = $inserted_user;
                  break;

            case 'add_user_register':
                   $check=DB::table('users')->where('emp_id',$request->emp_id)->first();
                   if($check)
                   {
                       $inserted_user = $check->id;
                       DB::table('rs_location2users')->insert(
                        ['user_id' => $inserted_user, 'location_id' => $request->loc_id,'last_edited' => session('admin_id') ]
                     );
                   }
                   else{
                   $inserted_user = DB::table('users')->insertGetId([

                            'name' => $request->name, 
                            'email' => $request->email,
                            'password'=> bcrypt($request->password),
                            'emp_id' => $request->emp_id 

                      ]);
                    
                      DB::table('rs_location2users')->insert(
                           ['user_id' => $inserted_user, 'location_id' => $request->loc_id,'last_edited' => '0' ]
                        );
                      }

                        $data['insert_id'] = $inserted_user;
                  break;
            
           case 'assign_hod':
                  DB::table('rs_departments')->where('id', $request->dept_id) ->update(['hod_id' => $request->user_id]);
                  // DB::table('users')->where('id',$request->user_id)->update(['user_type' => '1']);
                  $user=DB::table('users')->where('id',$request->user_id)->first();
                  $check=DB::table('admins')->where('email',$user->email)->count();
                  if($check=='0')
                  {
                  DB::table('admins')->insert(
                    ['name' => $user->name, 'email' => $user->email, 'job_title'=>'hod', 'password'=> $user->password, 'user_type'=> '2']
                  );
                  }
                  break;

                  
                  //HOD Admin Functions

          case 'get_list_cc':
                  $cc_list = DB::table('rs_costcenters')->get();
                  return $cc_list;
                  break;        
            
          case 'add_cc':
                  $added_cc = DB::table('rs_costcenters')->insertGetId(
                  ['number' => $request->number, 'department' => $request->dept_id, 'last_edited' => session('user_id')]
                  );
                  $data['added_id'] = $added_cc;
                  break; 
          
          case 'delete_cc':
                  rs_costcenters::where('id',$request->cc_id)->delete();
                  break;

          case 'store_levels':
                  DB::table('rs_departments')->where('id',$request->dept_id)->update(['oc_levels' => $request->levels]);
                  break;

          case 'retrieve_levels':
                  $levels = DB::table('rs_departments')->where('id',$request->dept_id)->get();
                  return $levels;
                  break;

          case 'add_reporting':
                  $reporting_id = DB::table('rs_reporting')->insertGetId(
                  ['department' => $request->dept_id, 'level' => $request->level, 'reporter' => $request->reporter, 'reportee' => $request->reportee,'last_edited' => session('user_id')]
                  );
                  $reportee_details = DB::table('rs_reporting')
                  ->join('users','users.id','=','rs_reporting.reportee')
                  ->where('rs_reporting.id',$reporting_id)
                  ->select('users.name','users.emp_id','users.id','rs_reporting.id as r_id')
                  ->get();
                  return $reportee_details;
                  break; 

          case 'del_reporting':
                  // $reporter_id = DB::table('rs_reporting')->where('department',$request->dept_id)->where('level',$request->level)->where('reportee',$request->reportee)->first();
                  // $changes = DB::table('rs_reporting')->where('department',$request->dept_id)->where('level',$request->level+1)->where('reporter',$request->reportee)->get();
                  // foreach($changes as $change)
                  // {
                  //   DB::table('rs_reporting')->insert(
                  //     ['department' => $request->dept_id, 'level' => $request->level, 'reporter' => $reporter_id->reporter, 'reportee' => $change->reportee,'last_edited' => session('admin_id')]
                  //     );

                  //   DB::table('rs_reporting')->where('department',$request->dept_id)->where('level',$request->level+1)->where('reporter',$request->reportee)->where('reportee',$change->reportee)->delete();
                      
                  // }
                  rs_reporting::where('id',$request->entry_id)->delete();
                  break;

          case 'allocate_cc':
                  $entry_id = DB::table('rs_cc2modules')->insertGetId(
                  ['user' => $request->user_id, 'costcenter' => $request->cc_id, 'module' => $request->module_id, 'budget' => $request->budget, 'last_edited' => session('user_id')]
                  );
                  $entries=DB::table('rs_cc2modules')
                  ->join('rs_costcenters','rs_costcenters.id','=','rs_cc2modules.costcenter')
                  ->join('rs_modules_programmer','rs_modules_programmer.id','=','rs_cc2modules.module')
                  ->where('rs_cc2modules.id',$entry_id)
                  ->select('rs_costcenters.number','rs_costcenters.id','rs_cc2modules.budget','rs_cc2modules.actual','rs_modules_programmer.module_name as m_name','rs_modules_programmer.id as m_id','rs_cc2modules.id as cc2m_id')
                  ->get();
                  return $entries;
                  break;

          case 'del_allocate_cc':
                  rs_cc2modules::where('id',$request->entry_id)->delete();
                  break;

          case 'edit_budget':
                  DB::table('rs_cc2modules')->where('id',$request->entry_id)->update(['budget' => $request->content]);
                  break;  

          case 'assign_admin2module':
                  if($request->tbl_id){
                    DB::table('rs_admin2modules')
                        ->where('id', $request->tbl_id)
                        ->update(['user_id' => $request->user_id]);
                  }else{
                      DB::table('rs_admin2modules')->insert([
                        'user_id' => $request->user_id, 
                        'module_id' => $request->module_id,
                        'department' => $request->dept_id,
                        'last_edited' => session('user_id')
                      ]);
                  }
                  break;     

          case 'add_modules':
                DB::table('rs_modules')->insert([
                  'name' => $request->module_name, 
                  'department' => $request->dept_id
                  ]);
                  
                  break; 

          default:
              $data['success'] = 'false';
        }
        
        return $data;
      }
  }

}