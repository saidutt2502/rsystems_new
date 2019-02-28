<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApprovalTraits;
use DB;
use Session;

use App\Mail\ProductionUpdated;



class ProductionController extends Controller
{

    public function index()
    {
      $depts = DB::table('rs_production_dept')->where('location_id',session('location'))->select('department','id')
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

           if($request->user_list)
          {
        foreach($request->user_list as $each_user){
          DB::table('rs_production_user_list')->insert(
            ['user_id' => $each_user,'location_id' => session('location'),'last_edited' => session('user_id')]
          );
        }
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
            ['department' =>  $request->department ,'last_edited' => session('user_id'),'location_id' => session('location')]
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

    public function schedule_production()
    {
      $edit_permission=DB::table('rs_production_user_list')->where('user_id',session('user_id'))->where('location_id',session('location'))->first();
      if($edit_permission)
      {
        $depts = DB::table('rs_production_dept')->where('location_id',session('location'))->select('department','id')
        ->get();
      }
      else
      {
        $depts = DB::table('rs_production_dept')
                 ->join('rs_users_production','rs_users_production.production_dept_id','=','rs_production_dept.id')
        ->where('rs_production_dept.location_id',session('location'))
        ->where('rs_users_production.user_id',session('user_id'))
        ->select('rs_production_dept.id','rs_production_dept.department')
        ->get();
      }
      
      return view('production.schedule_production')->withDept($depts);
    }

    public function production_schedule_chart(Request $request)
    {
      $depts = DB::table('rs_production_dept')->where('location_id',session('location'))->select('department','id')
      ->get();
      $selected_dept_name = DB::table('rs_production_dept')->where('id',$request->department)->value('department');
      $sub_depts = DB::table('rs_company_production')->where('dept_id',$request->department)->get();

      if($request->month=='1')
      $month_name='January';
      if($request->month=='2')
      $month_name='February';
      if($request->month=='3')
      $month_name='March';
      if($request->month=='4')
      $month_name='April';
      if($request->month=='5')
      $month_name='May';
      if($request->month=='6')
      $month_name='June';
      if($request->month=='7')
      $month_name='July';
      if($request->month=='8')
      $month_name='August';
      if($request->month=='9')
      $month_name='September';
      if($request->month=='10')
      $month_name='October';
      if($request->month=='11')
      $month_name='November';
      if($request->month=='12')
      $month_name='December';

     foreach($sub_depts as $each_dept)
     {
      $exists=DB::table('rs_production_chart')->where('subdept_id',$each_dept->id)->where('month',$request->month)->where('year',$request->year)->first();

      if(!$exists)
      {
        $days=cal_days_in_month (CAL_GREGORIAN, $request->month, $request->year);
        for($i=1;$i<=$days;$i++)
        {
          DB::table('rs_production_chart')->insert(
            ['day' => $i, 'month' => $request->month ,'year' =>$request->year ,'subdept_id' => $each_dept->id,'last_edited' => session('user_id')]
          );
        }
       
      }

     }
     

      return view('production.production_chart')->withSubdept($sub_depts)->withDept($depts)->withMonthid($request->month)->withMonthname($month_name)->withYear($request->year)->withDepartmentid($request->department)->withDepartmentname($selected_dept_name);
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
                    ->where('users.user_type_id','1')
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
                  ->where('users.user_type_id','1')
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

              case 'update_planned':
 
              $achived=DB::table('rs_production_chart')->where('id',$request->id)->value('achived');
              $table_entry=DB::table('rs_production_chart')->where('id',$request->id)->first();
              $no_day=cal_days_in_month(CAL_GREGORIAN, $table_entry->month, $table_entry->year);
              

              DB::table('rs_production_chart')
                              ->where('id', $request->id)
                              ->update([
                                  'planned' => $request->data,
                                  'difference' => $achived-$request->data,
                                  'last_edited' => session('user_id'), 
                              ]);
              for($i=1;$i<=$no_day;$i++)
              {
                $sum=0;
                for($day=$i;$day>=1;$day--)
                {
                $running_difference = DB::table('rs_production_chart')->where('day',$day)->where('month',$table_entry->month)->where('year',$table_entry->year)->where('subdept_id',$table_entry->subdept_id)->value('difference');
                $sum += $running_difference;
                 }
                 DB::table('rs_production_chart')
                              ->where('day',$i)
                              ->where('month',$table_entry->month)
                              ->where('year',$table_entry->year)
                              ->update([
                                  'running_difference' => $sum, 
                              ]);
              }                
              
              
              break;

              case 'update_achived':
 
              $planned=DB::table('rs_production_chart')->where('id',$request->id)->value('planned');
              $table_entry=DB::table('rs_production_chart')->where('id',$request->id)->first();
              $no_day=cal_days_in_month(CAL_GREGORIAN, $table_entry->month, $table_entry->year);
               

              DB::table('rs_production_chart')
                              ->where('id', $request->id)
                              ->update([
                                  'achived' => $request->data,
                                  'difference' => $request->data-$planned,
                                  'last_edited' => session('user_id'), 
                              ]);

                  for($i=1;$i<=$no_day;$i++)
              {
                $sum=0;
                for($day=$i;$day>=1;$day--)
                {
                $running_difference = DB::table('rs_production_chart')->where('day',$day)->where('month',$table_entry->month)->where('year',$table_entry->year)->where('subdept_id',$table_entry->subdept_id)->value('difference');
                $sum += $running_difference;
                 }
                 DB::table('rs_production_chart')
                              ->where('day',$i)
                              ->where('month',$table_entry->month)
                              ->where('year',$table_entry->year)
                              ->update([
                                  'running_difference' => $sum, 
                              ]);
              }   

                                          
              break;

              // case 'save_changes':
 
              
              // $table_entry=DB::table('rs_production_chart')->where('id',$request->id)->first();

              //                 for($day=$table_entry->day;$day>=1;$day--)
              //                 {
              //                   $running_difference = DB::table('rs_production_chart')->where('day',$day)->where('month',$table_entry->month)->where('year',$table_entry->year)->value('difference');
              //                   $sum += $running_difference;
              //                 }
                              
              //                 DB::table('rs_production_chart')
              //                                 ->where('id', $request->id)
              //                                 ->update([
              //                                     'running_difference' => $sum, 
              //                                 ]);                
              // break;

              case 'publish_list':
                  $user_prod=DB::table('rs_users_production')
                      ->join('users','users.id','=','rs_users_production.user_id')
                      ->where('rs_users_production.production_dept_id',$request->deptid)
                      ->select('users.email as email')
                      ->get();

                  $userClicked = DB::table('users')
                                  ->where('id',session('user_id'))
                                  ->value('name');

                  $deptName =  DB::table('rs_production_dept')->where('id', $request->deptid)->value('department');

                      $mailData = array(
                        'dept'=>  $deptName,
                        'user'=> $userClicked
                       );

                        foreach ($user_prod as $eachUser) {
                           \Mail::to($eachUser->email)->send(new ProductionUpdated($mailData));
                        }

                        $data=1;

              break;

            }

          return $data;
      }
  }
  

}