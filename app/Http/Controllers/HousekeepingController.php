<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use DB;
use App\rs_hk_stock;


class HousekeepingController extends Controller
{
    public function index()
    {
        $items = DB::table('rs_hk_stock')
                    ->where('location_id',session('location'))
                    ->whereNull('deleted_at')
                    ->get();

        return view('housekeeping.stock')->withItem($items);
    }

    public function my_request()
    {

        $item_requests = DB::table('rs_hkrequests')
            ->join('rs_hk_stock', 'rs_hk_stock.id', '=', 'rs_hkrequests.item_id')
            ->join('rs_status', 'rs_status.id', '=', 'rs_hkrequests.status')
            ->select('rs_hkrequests.*', 'rs_hk_stock.name as item_name','rs_status.html_string as html_status')
            ->where('rs_hkrequests.user_id',session('user_id'))
            ->get();

        return view('housekeeping.my_request')->withRequest($item_requests);
    }

    public function item_request()
    {
        $user = DB::table('users')
                    ->where('id',session('user_id'))
                    ->first();

        $items = DB::table('rs_hk_stock')->where('location_id',session('location'))->get();

        return view('housekeeping.item_request')->withUser($user)->withItems($items);
    }

    public function ajax_stationary_controller(Request $request)
  {
    $data = array("success"=>"true","insert_id"=>"0","data"=>"","msg"=>"");

      if($request->ajax()){

        switch ($request->function_name) {

          case 'add_item':
                $id = DB::table('rs_hk_stock')->insertGetId([
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
                    DB::table('rs_hk_stock')
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

          case 'update_stock':
                                
                foreach($request->id as $key => $value){
                    DB::table('rs_hk_stock')
                            ->where('id', $value)
                            ->increment('available',$request->qty[$key],['last_edited' =>session('user_id'),'updated_at'=> DB::raw('CURRENT_TIMESTAMP')]);
                    
                    DB::table('rs_hk_stockupdate')->insertGetId([
                                'item_id' => $value, 
                                'user_id' => session('user_id'),
                                'quantity_updated'=> $request->qty[$key],
                                'updated_at' =>  DB::raw('CURRENT_TIMESTAMP')
                          ]);
                    }
                 break;

          case 'delete_item':
                rs_hk_stock::where('id', $request->id)->delete();
                 break;

        //     default:
        //         $data['success'] = 'false';
        }

        return $data;
    }

 }


 public function forms_hk_functions(Request $request)
 {
    switch ($request->function_name) {

        case 'item_request':

        foreach($request->item_id as $key => $value){
                $id = DB::table('rs_hkrequests')->insertGetId([
                    'user_id' => $request->user_id, 
                    'item_id' => $value,
                    'location_id'=> session('location'),
                    'quantity' => $request->qty[$key],
                    'pickup_date' => $request->pickup_date ,
                    'status' => '5' ,
                    'issue_status' => '5' ,
                ]);
                
            //Sending for approval (params:costcenter,Insert Id, Table-name)
                // $this->get_higher_up($request->cc_id,$id,'rs_stationaryrequests');
        }
        return redirect()->action('HousekeepingController@my_request'); 
        break;

        default:
                $data['success'] = 'false';
    }
 }
}
