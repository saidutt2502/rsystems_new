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
     $location = DB::table('rs_locations')->get();
    return view('admin.step_1')->withLocation($location);
  }

  public function step_2()
  {
     $location = DB::table('rs_locations')->get();
    return view('admin.step_2')->withLocation($location);
  }

  public function step_3()
  {
     $location = DB::table('rs_locations')->get();
    return view('admin.step_3')->withLocation($location);
  }

  public function location_user($id)
  {
    $location = DB::table('rs_locations')->where('id', $id)->value('name');
    $users = DB::table('users')
            ->select('users.*')
            ->join('rs_location2users', 'users.id', '=', 'rs_location2users.user_id')
            ->join('rs_locations', 'rs_locations.id', '=', 'rs_location2users.location_id')
            ->where('rs_location2users.location_id',$id)
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

    return view('admin.department_hod')->withId($id)->withName($location)->withDepartments($departments);
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
                  break;

            case 'list_departments':
                  $dept2location = DB::table('rs_departments')->select('rs_departments.name as name','rs_departments.id as id') 
                  ->join('rs_location2department', 'rs_location2department.department', '=', 'rs_departments.id')
                  ->where('rs_location2department.location', '=', $request->id)
                  ->get();

                  $data['data'] = $dept2location;
                  break;

            case 'check_user_details':
                    $email_check = DB::table('users')->where('email', $request->email)->exists();
                    $epm_id = DB::table('users')->where('emp_id', $request->emp_id)->exists();

                    if($email_check &&  $epm_id){
                        $data['success'] = 'false';
                        $data['msg'] = 'Email Address and Employee Code already Exists';
                    }else if(!$email_check &&  $epm_id){
                      $data['success'] = 'false';
                      $data['msg'] = 'Employee Code already Exists';
                    }else if($email_check &&  !$epm_id){
                      $data['success'] = 'false';
                      $data['msg'] = 'Email Address already Exists';
                    }else{
                      $data['success'] = 'true';
                    }

                  break;

            case 'delete_user':
                  DB::table('users')->where('id', $request->user_id)->delete();
                  break;

            case 'add_user':
                   $inserted_user = DB::table('users')->insertGetId([

                            'name' => $request->name, 
                            'email' => $request->email,
                            'password'=> bcrypt($request->password),
                            'emp_id' => $request->emp_id 

                      ]);

                      DB::table('rs_location2users')->insert(
                           ['user_id' => $inserted_user, 'location_id' => $request->loc_id,'last_edited' => session('user_id') ]
                        );

                        $data['insert_id'] = $inserted_user;
                  break;
            
            case 'get_user_list':
                  $users=DB::table('users')->get();
                  return $users;
                  break;
          
            case 'assign_hod':
                  $dept=DB::table('rs_departments')->where('id', $request->dept_id)->first();
                  
                  break;
                     

          default:
              $data['success'] = 'false';
        }
        
        return $data;
      }
  }

}