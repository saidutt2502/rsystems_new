<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\rs_safety_shoes;


use Session;
use DB;

class SafetyController extends Controller
{
    public function index()
    {
        $shoes = DB::table('rs_safety_shoes')
                    ->where('location_id',session('location'))
                    ->whereNull('deleted_at')
                    ->get();

        return view('safety.stockmaster')->withShoes($shoes);
    }

    public function my_request()
    {

        $shoes_requests = DB::table('rs_safety_requests')
            ->join('rs_safety_shoes', 'rs_safety_shoes.id', '=', 'rs_safety_requests.shoes_id')
            ->join('rs_status', 'rs_status.id', '=', 'rs_safety_requests.status')
            ->select('rs_safety_requests.*', 'rs_safety_shoes.brand as brand_name','rs_safety_shoes.size as size','rs_status.html_string as html_status')
            ->where('rs_safety_requests.user_id',session('user_id'))
            ->get();

        return view('safety.my_request')->withRequest($shoes_requests);
    }

    public function shoes_request()
    {
        $user = DB::table('users')
                    ->where('id',session('user_id'))
                    ->first();

        $shoes = DB::table('rs_safety_shoes')->where('location_id',session('location'))->get();

        return view('safety.shoes_request')->withUser($user)->withShoes($shoes);
    }

    public function forms_safety_shoes(Request $request)
 {
     $date=date("Y-m-d");
    switch ($request->function_name) {

        case 'shoes_request':

        foreach($request->shoes_id as $key => $value){

                $tags = explode(',' , $request->emp_id[$key]);
                $quantity=count($tags);

                $id = DB::table('rs_safety_requests')->insertGetId([
                    'pickup_date' => $date,
                    'shoes_id' => $request->shoes_id[$key],
                    'user_id' => $request->user_id,
                    'emp_id' => $request->emp_id[$key],
                    'quantity' => $quantity,
                    'status' => '5',
                ]);
                
            //Sending for approval (params:costcenter,Insert Id, Table-name)
                // $this->get_higher_up($request->cc_id,$id,'rs_stationaryrequests');
        }
        return redirect()->action('SafetyController@my_request'); 
        break;

        default:
                $data['success'] = 'false';
    }
 }

      // Ajax Calls 
  public function ajax_safety_controller(Request $request)
  {
    $data = array("success"=>"true","insert_id"=>"0","data"=>"","msg"=>"");

      if($request->ajax()){

        switch ($request->function_name) {

          case 'add_shoes':
                $id = DB::table('rs_safety_shoes')->insertGetId([
                    'brand' => $request->brand, 
                    'size' => $request->size,
                    'costpu'=> $request->costpu,
                    'threshold' => $request->threshold,
                    'location_id' =>session('location'),
                    'last_edited' =>session('user_id') ,
              ]);
                 $data['insert_id'] = $id;
                 break;

          case 'update_shoes':
                    DB::table('rs_safety_shoes')
                            ->where('id', $request->id)
                            ->update([
                                'brand' => $request->brand, 
                                'size' => $request->size,
                                'costpu'=> $request->costpu,
                                'available'=> $request->available,
                                'threshold' => $request->threshold,
                                'location_id' =>session('location'),
                                'last_edited' =>session('user_id') ,
                            ]);

                 break;

          case 'update_stock':
                                
                foreach($request->id as $key => $value){
                    DB::table('rs_safety_shoes')
                            ->where('id', $value)
                            ->increment('available',$request->qty[$key],['last_edited' =>session('user_id'),'updated_at'=> DB::raw('CURRENT_TIMESTAMP')]);
                    
                    DB::table('rs_stockUpdateSafety')->insertGetId([
                                'shoe_id' => $value, 
                                'user_id' => session('user_id'),
                                'quantity_updated'=> $request->qty[$key],
                                'updated_at' =>  DB::raw('CURRENT_TIMESTAMP')
                          ]);
                    }
                 break;

          case 'delete_shoes':
                rs_safety_shoes::where('id', $request->id)->delete();
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

        foreach($request->item_id as $key => $value){
                $id = DB::table('rs_stationaryrequests')->insertGetId([
                    'user_id' => $request->user_id, 
                    'item_id' => $value,
                    'location_id'=> session('location'),
                    'costcenter_id' => $request->cc_id,
                    'quantity' => $request->qty[$key],
                    'remarks' => $request->remarks ,
                    'pickup_date' => $request->pickup_date ,
                    'time_slot' => $request->time_slot ,
                ]);
                
            //Sending for approval (params:costcenter,Insert Id, Table-name)
                $this->get_higher_up($request->cc_id,$id,'rs_stationaryrequests');
        }
        return redirect()->action('StationaryController@my_request'); 
        break;

        default:
                $data['success'] = 'false';
    }
 }

}
