<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;



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

    $users = DB::table('users')
              ->select('id','name')
              ->get();

  


   return view('admin.step_3')->withLocation($location)->withDeptlocation($dept2location)->withUsers($users);
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

  public function hod_cc()
  {
    $admins = DB::table('admins')->where('id',session('user_id'))->value('email');
    $users = DB::table('users')->where('email',$admins)->value('id');
    $department = DB::table('rs_departments')->where('hod_id',$users)->get();
    return view('admin.hod_cc')->withDepartments($department);
  }

  public function oc()
  {
    $admins = DB::table('admins')->where('id',session('user_id'))->value('email');
    $users = DB::table('users')->where('email',$admins)->value('id');
    $department = DB::table('rs_departments')->where('hod_id',$users)->get();
    return view('admin.oc_details')->withDepartments($department);
  }

  public function oc_structure()
  {
    $admins = DB::table('admins')->where('id',session('user_id'))->value('email');
    $users = DB::table('users')->where('email',$admins)->value('id');
    $department = DB::table('rs_departments')->where('hod_id',$users)->get();
    return view('admin.oc_structure')->withDepartments($department)->withHodid($users);
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
                     'last_edited' => session('user_id'),
                 ]);
                 $data['insert_id'] = $id;
                 break;

          case 'del_location':
                DB::table('rs_locations')->where('id', '=', $request->id)->delete();
                DB::table('rs_location2department')->where('location', '=', $request->id)->delete();
                 break;
                 
          case 'add_department':
          
          //Adding entry to Departments table
          $id = DB::table('rs_departments')->insertGetId([
            'name' => $request->name,
            'last_edited' => session('user_id')
            ]);

                //Adding entry to rs_location2department
                 DB::table('rs_location2department')->insert([
                   'department' => $id,
                   'location' => $request->location_id,
                   'last_edited' => session('user_id')
                   ]);

                   $data['insert_id'] = $id;
                   break;

            case 'del_department':
                  DB::table('rs_departments')->where('id', '=', $request->id)->delete();
                  DB::table('rs_location2department')->where('department', '=', $request->id)->delete();
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
                  DB::table('rs_location2users')->where('user_id', $request->user_id)->delete();
                  break;

            case 'add_user':
                   $check=DB::table('users')->where('emp_id',$request->emp_id)->first();
                   if($check)
                   {
                       $inserted_user = $check->id;
                       DB::table('rs_location2users')->insert(
                        ['user_id' => $inserted_user, 'location_id' => $request->loc_id,'last_edited' => session('user_id') ]
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
                           ['user_id' => $inserted_user, 'location_id' => $request->loc_id,'last_edited' => session('user_id') ]
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
                  ['number' => $request->number, 'department' => $request->dept_id]
                  );
                  $data['added_id'] = $added_cc;
                  break; 
          
          case 'delete_cc':
                  DB::table('rs_costcenters')->where('id',$request->cc_id)->delete();
                  break;
          case 'store_levels':
                  DB::table('rs_departments')->where('id',$request->dept_id)->update(['oc_levels' => $request->levels]);
                  break;
          case 'retrieve_levels':
                  $levels = DB::table('rs_departments')->where('id',$request->dept_id)->get();
                  return $levels;
                  break;
          case 'add_reporting':
                  DB::table('rs_reporting')->insert(
                  ['department' => $request->dept_id, 'level' => $request->level, 'reporter' => $request->reporter, 'reportee' => $request->reportee]
                  );
                  $reportee_details = DB::table('users')->where('id',$request->reportee)->get();
                  return $reportee_details;
                  break; 
          case 'retrieve_hierarchy':
                  $hierarchy = DB::table('rs_reporting')
                  ->join('users','users.id','=','rs_reporting.reportee')
                  ->where('rs_reporting.department',$request->dept_id)
                  ->where('rs_reporting.level',$request->level)
                  ->select('users.name','users.emp_id','users.id')
                  ->get();
                  return $hierarchy;
                  break;
          case 'del_reporting':
                  DB::table('rs_reporting')->where('department',$request->dept_id)->where('level',$request->level)->where('reportee',$request->reportee)->delete();
                  break;                              
          default:
              $data['success'] = 'false';
        }
        
        return $data;
      }
  }

}