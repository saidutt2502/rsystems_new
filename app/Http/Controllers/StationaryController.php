<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApprovalTraits;

use Session;
use DB;

class StationaryController extends Controller
{

    // Included to Get the Higher Up person to send for approval
        use ApprovalTraits;

    public function __construct()
    {
        /* Function to get module ID */
        if(!session('module_id')){
                $dept_id = DB::table('rs_location2department')->where('location',session('location') )->get();

                foreach($dept_id as $each_dept){

                    $correct_dept = DB::table('rs_modules')->where('department', $each_dept->department)->where('name','Stationary')
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
        $items = DB::table('rs_items')
                    ->where('location_id',session('location'))
                    ->get();

        return view('stationary.items')->withItem($items);
    }

    public function my_request()
    {

        $item_requests = DB::table('rs_stationaryrequests')
            ->join('rs_items', 'rs_items.id', '=', 'rs_stationaryrequests.item_id')
            ->join('rs_costcenters', 'rs_costcenters.id', '=', 'rs_stationaryrequests.costcenter_id')
            ->join('rs_status', 'rs_status.id', '=', 'rs_stationaryrequests.status')
            ->select('rs_stationaryrequests.*', 'rs_items.name as item_name', 'rs_costcenters.number as cc_number','rs_status.html_string as html_status')
            ->where('rs_stationaryrequests.user_id',session('user_id'))
            ->get();

        return view('stationary.my_request')->withRequest($item_requests);
    }

    public function item_request()
    {
        $user = DB::table('users')
                    ->where('id',session('user_id'))
                    ->first();

        $cost_center = DB::table('rs_costcenters')->get();

        $items = DB::table('rs_items')->get();

        return view('stationary.item_request')->withUser($user)->withCc($cost_center)->withItems($items);
    }

     // Ajax Calls 
  public function ajax_stationary_controller(Request $request)
  {
    $data = array("success"=>"true","insert_id"=>"0","data"=>"","msg"=>"");

      if($request->ajax()){

        switch ($request->function_name) {

          case 'add_item':
                $id = DB::table('rs_items')->insertGetId([
                    'code' => $request->code, 
                    'name' => $request->name,
                    'costpu'=> $request->costpu,
                    'threshold' => $request->threshold,
                    'location_id' =>session('location'),
                    'last_edited' =>session('user_id') ,
              ]);
                 $data['insert_id'] = $id;
                 break;

          case 'update_item':
                    DB::table('rs_items')
                            ->where('id', $request->id)
                            ->update([
                                'code' => $request->code, 
                                'name' => $request->name,
                                'costpu'=> $request->costpu,
                                'available'=> $request->available,
                                'threshold' => $request->threshold,
                                'location_id' =>session('location'),
                                'last_edited' =>session('user_id') ,
                            ]);

                 break;

          case 'delete_item':
                DB::table('rs_items')->where('id', $request->id)->delete();
                 break;

            default:
                $data['success'] = 'false';
        }

        return $data;
    }

 }

 public function forms_stationary_functions(Request $request)
 {
    switch ($request->function_name) {

        case 'item_request':
                $id = DB::table('rs_stationaryrequests')->insertGetId([
                    'user_id' => $request->user_id, 
                    'item_id' => $request->item_id,
                    'location_id'=> session('location'),
                    'costcenter_id' => $request->cc_id,
                    'quantity' => $request->qty,
                    'remarks' => $request->remarks ,
                    'pickup_date' => $request->pickup_date ,
                    'time_slot' => $request->time_slot ,
                ]);
                
            //Sending for approval (params:costcenter,Insert Id, Table-name)
                $this->get_higher_up($request->cc_id,$id,'rs_stationaryrequests');

        return redirect()->action('StationaryController@my_request'); 

        default:
                $data['success'] = 'false';
    }
 }


}