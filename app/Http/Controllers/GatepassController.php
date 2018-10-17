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


   // Ajax Calls 
   public function ajax_gatepass_controller(Request $request)
   {
     $data = array("success"=>"true","insert_id"=>"0","data"=>"","msg"=>"");
 
       if($request->ajax()){
 
         switch ($request->function_name) {
 
           case 'calculate_total':
                 $data['total']= DB::table('rs_gp_entries')
                 ->where('user_id',$request->user_id)
                 ->where('purpose','!=','Official Work')
                 ->where('date_','>=',$request->year.'-'.$request->month.'-01')
                 ->where('date_','<=',$request->year.'-'.$request->month.'-31')
                 ->sum('total');
                 $limit=DB::table('rs_gp_settings')->first();
                 $data['limit']=$limit->hours;
                 break;
            
            case 'add_entry':
                if($request->to)
                {
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
                    ]);
                }
                else
                {
                  $id = DB::table('rs_gp_entries')->insertGetId([
                  'user_id' => $request->user_id, 
                  'date_' => $request->date,
                  'shift_id'=> $request->shift,
                  'purpose' => $request->purpose,
                  'reason' => $request->reason,
                  'from' => $request->from,
                  'status' => '1' ,
                  'location_id'=> session('location'),
                   ]);
                }
               //Sending for approval (params:costcenter,Insert Id, Table-name)
               $this->get_higher_up1($id,'rs_gp_entries');
                 break;         
 
             default:
                 $data['success'] = 'false';
         }
 
         return $data;
     }
 
  }
}
