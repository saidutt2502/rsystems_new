<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\ApprovalTraits;

use Session;
use DB;

class GatepassController extends Controller
{
    use ApprovalTraits;

    public function __construct()
    {
        /* Function to get module ID */
        if(!session('module_id')){
                $dept_id = DB::table('rs_location2department')->where('location',session('location') )->get();

                foreach($dept_id as $each_dept){

                    $correct_dept = DB::table('rs_modules')->where('department', $each_dept->department)->where('name','Gatepass')
                    ->first();

                    if($correct_dept){
                        session(['module_id' =>  $correct_dept->id]); 
                        session(['dept_id' =>  $each_dept->department]); 
                    }
            }
        }

    }

    public function index()
    {
        $entries = DB::table('rs_gp_settings')->get();
        $entry = DB::table('rs_gp_settings')->first();
        $count=count($entries);
        $counter=$count;
        $hours=$entry->hours;
        

        return view('gatepass.settings')->withEntries($entries)->withCount($count)->withCounter($counter)->withHours($hours);
    }

    public function settings(Request $request)
  {
    DB::table('rs_gp_settings')->delete();
    for($i=0;$i< count($request->name);$i++)
    {
        DB::table('rs_gp_settings')->insert([
            'name' => $request->name[$i], 
            'from' => $request->from[$i],
            'to'=> $request->to[$i],
            'hours' => $request->hours,
            'user_id' => session('user_id')
        ]);
    }
    return redirect()->action('GatepassController@index');
  }

    public function my_request()
  {
    $requests = DB::table('rs_gp_entries')
            ->join('rs_status', 'rs_status.id', '=', 'rs_gp_entries.status')
            ->where('rs_gp_entries.user_id',session('user_id'))
            ->get();

        return view('gatepass.my_request')->withRequest($requests);
  }

  public function gp_request()
  {
      $shifts = DB::table('rs_gp_settings')->get();

      $user = DB::table('users')
                    ->where('id',session('user_id'))
                    ->first();

      return view('gatepass.fill_gp')->withShifts($shifts)->withUser($user);
  }

  public function gp_close()
  {
     $gp_details=DB::table('rs_gp_entries')
                 ->join('users','users.id','=','rs_gp_entries.user_id')
                 ->select('users.name as name','users.emp_id as emp_id', 'rs_gp_entries.*')
                 ->whereIn('rs_gp_entries.status',['2','6'])->get();

      return view('gatepass.gp_close')->withDetails($gp_details);
  }


   // Ajax Calls 
   public function ajax_gatepass_controller(Request $request)
   {
     $data = array("success"=>"true","insert_id"=>"0","data"=>"","msg"=>"");
 
       if($request->ajax()){
 
         switch ($request->function_name) {
 

           case 'check_difference':
                 $details=DB::table('rs_gp_settings')->where('id',$request->shift_id)->first();
                 $data['limit']=$details->hours*60;
                 if($request->to)
                 {
                    $date1 = date('H:i', strtotime("$request->from"));
                    $date2 = date('H:i', strtotime("$request->to"));
      
                    $to_time = strtotime($date1);
                    $from_time = strtotime($date2);
                    $whole=abs($to_time - $from_time)/60;
                    $data['value'] = $whole;
                 }
                 else
                 {
                    $date1 = date('H:i', strtotime("$request->from"));
                    $date2 = date('H:i', strtotime("$details->to"));
   
                    $to_time = strtotime($date1);
                    $from_time = strtotime($date2);
                    $whole=abs($to_time - $from_time)/60;
                    $data['value'] = $whole;
                 }

                 break;
    
           case 'calculate_total':
                 $total= DB::table('rs_gp_entries')
                 ->where('user_id',$request->user_id)
                 ->where('purpose','!=','Official Work')
                 ->where('date_','>=',$request->year.'-'.$request->month.'-01')
                 ->where('date_','<=',$request->year.'-'.$request->month.'-31')
                 ->where('status','!=','3')
                 ->sum('total');
                 $data['total']=$total+$request->requested_time/60;
                 $limit=DB::table('rs_gp_settings')->first();
                 $data['limit']=$limit->hours;
                 break;
            
            case 'add_entry':
                if($request->to)
                {
                  $date1 = date('H:i', strtotime("$request->from"));
                  $date2 = date('H:i', strtotime("$request->to"));
      
                  $to_time = strtotime($date1);
                  $from_time = strtotime($date2);
                  $whole=abs($to_time - $from_time)/3600; 

                  $id = DB::table('rs_gp_entries')->insertGetId([
                  'user_id' => $request->user_id, 
                  'date_' => $request->date,
                  'shift_id'=> $request->shift,
                  'purpose' => $request->purpose,
                  'reason' => $request->reason,
                  'from' => $request->from,
                  'to' => $request->to,
                  'status' => '1' ,
                  'location_id'=> session('location'),
                  'total'=> $whole,
                    ]);
                }
                else
                {

                  $details=DB::table('rs_gp_settings')->where('id',$request->shift)->first();
                  $date1 = date('H:i', strtotime("$request->from"));
                  $date2 = date('H:i', strtotime("$details->to"));
      
                  $to_time = strtotime($date1);
                  $from_time = strtotime($date2);
                  $whole=abs($to_time - $from_time)/3600;  
                  $id = DB::table('rs_gp_entries')->insertGetId([
                  'user_id' => $request->user_id, 
                  'date_' => $request->date,
                  'shift_id'=> $request->shift,
                  'purpose' => $request->purpose,
                  'reason' => $request->reason,
                  'from' => $request->from,
                  'status' => '1' ,
                  'location_id'=> session('location'),
                  'total'=> $whole,
                   ]);
                }
               //Sending for approval (params:costcenter,Insert Id, Table-name)
               $this->get_higher_up1($id,'rs_gp_entries');
                 break;
                 
            case 'entry_close':
                  $detail=DB::table('rs_gp_entries')->where('id',$request->entry_id)->first();
                  if($detail->to==null)
                  {
                    DB::table('rs_gp_entries')
                    ->where('id', $request->entry_id)
                    ->update(['actualfrom' => $request->time,'actualdatef' => $request->date,'status' => '7']);
                  }
                  else
                  {
                    DB::table('rs_gp_entries')
                    ->where('id', $request->entry_id)
                    ->update(['actualfrom' => $request->time,'actualdatef' => $request->date,'status' => '6']);
                  }  
                   
                   break;

            case 'entry_close_in':
                   DB::table('rs_gp_entries')
                    ->where('id', $request->entry_id)
                    ->update(['actualto' => $request->time,'actualdatet' => $request->date,'status' => '7']);
                  break;
 
             default:
                 $data['success'] = 'false';
         }
 
         return $data;
     }
 
  }
}
