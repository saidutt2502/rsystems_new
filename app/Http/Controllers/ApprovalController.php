<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Session;

use DB;

class ApprovalController extends Controller
{
    public function index()
    {
        $approve_requests = DB::table('rs_approvals')
        ->join('rs_modules','rs_modules.id','=','rs_approvals.module_id')
        ->select('rs_approvals.*', 'rs_modules.name as module_name')
        ->where('rs_approvals.user_id',session('user_id'))
        ->orderBy('rs_approvals.updated_at','desc')
        ->get();

        $count_approvals = DB::table('rs_approvals')
                                    ->where('user_id',session('user_id'))
                                    ->where('status','1')
                                    ->count();

        return view('approvals.index')->withApprove($approve_requests)->withCount($count_approvals);
    }

    public function issues_approvals()
    {

        $issue_requests = DB::table('rs_stationaryrequests')
        ->join('users', 'users.id', '=', 'rs_stationaryrequests.user_id')
        ->join('rs_items', 'rs_items.id', '=', 'rs_stationaryrequests.item_id')
        ->join('rs_locations', 'rs_locations.id', '=', 'rs_stationaryrequests.location_id')
        ->join('rs_costcenters', 'rs_costcenters.id', '=', 'rs_stationaryrequests.costcenter_id')
        ->select('rs_stationaryrequests.id as main_id','users.name as name','users.emp_id as emp_id', 'rs_items.name as item_name', 'rs_items.id as item_id', 'rs_locations.name as loc_name','rs_costcenters.number as cost_center','rs_stationaryrequests.quantity as quantity','rs_stationaryrequests.remarks as remarks',
        'rs_stationaryrequests.pickup_date as p_date','rs_stationaryrequests.updated_at as updt_date',
        'rs_stationaryrequests.time_slot as time_slot')
        ->where('rs_stationaryrequests.status','2')
        ->where('rs_stationaryrequests.issue_status','5')
        ->get();

        $count_approvals = DB::table('rs_approvals')
                                    ->where('user_id',session('user_id'))
                                    ->where('status','1')
                                    ->count();

        return view('approvals.issues_approvals')->withIssues($issue_requests);
    }

    public function ajax_approval_controller(Request $request){
        $data = array("success"=>"true","insert_id"=>"0","data"=>"","msg"=>"");

        if($request->ajax()){
  
          switch ($request->function_name) {

            case 'approve_request':

            //Updating in the approvals tables
                DB::table('rs_approvals')
                        ->where('id', $request->id)
                        ->update(['status' => 2]);

            //Getting the parent table id and name
            $src_table_id = DB::table('rs_approvals')->where('id', $request->id)->value('src_id');
            $src_table = DB::table('rs_approvals')->where('id', $request->id)->value('src_table');

            //Updating in the parent table
            if($request->module=='Stationary')
            {
            DB::table($src_table)
                        ->where('id', $src_table_id)
                        ->update(['status' => 5]);
            }
            else if ($request->module=='Gatepass')
            {
            DB::table($src_table)
                        ->where('id', $src_table_id)
                        ->update(['status' => 2]);
            }
            else if ($request->module=='Taxi')
            {
            DB::table($src_table)
                        ->where('id', $src_table_id)
                        ->update(['status' => 2]);
            }

            break;

            case 'decline_request':
                DB::table('rs_approvals')
                        ->where('id', $request->id)
                        ->update(['status' => 3]);

            //Getting the parent table id and name
            $src_table_id = DB::table('rs_approvals')->where('id', $request->id)->value('src_id');
            $src_table = DB::table('rs_approvals')->where('id', $request->id)->value('src_table');

            //Updating in the parent table
            DB::table($src_table)
                        ->where('id', $src_table_id)
                        ->update(['status' => 3]);
            break;

            case 'issue_request':
            //Updating in the parent table
            DB::table('rs_stationaryrequests')
                        ->where('id', $request->id)
                        ->update([
                            'status' => 4,
                            'issue_status' => 4,
                            'issued_by' => session('user_id'),
                            'issued_date' => DB::raw('CURRENT_TIMESTAMP')
                        ]);
            
            DB::table('rs_items')
                        ->where('id', $request->item_id)
                        ->decrement('available',$request->item_qty);

            break;

             default:
             $data['success'] = 'false';

            }
        return $data;
        }

    }

}
