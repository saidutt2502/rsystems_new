<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\rs_stationaryrequests;
use App\rs_hkrequests;
use App\rs_safety_requests;


use App\Mail\StationaryThreshold;

use Session;

use DB;

class ApprovalController extends Controller
{
    public function index()
    {
        $approve_requests = DB::table('rs_approvals')
        ->join('rs_modules_programmer','rs_modules_programmer.id','=','rs_approvals.module_id')
        ->select('rs_approvals.*', 'rs_modules_programmer.module_name as module_name')
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

        $stationary_admin=DB::table('rs_admin2modules')->where('user_id',session('user_id'))->where('module_id','1')->first();
        $safety_admin=DB::table('rs_admin2modules')->where('user_id',session('user_id'))->where('module_id','4')->first();
        $hk_admin=DB::table('rs_admin2modules')->where('user_id',session('user_id'))->where('module_id','6')->first();

        if($stationary_admin)
        {
            $issue_requests = DB::table('rs_stationaryrequests')
        ->join('users', 'users.id', '=', 'rs_stationaryrequests.user_id')
        ->join('rs_items', 'rs_items.id', '=', 'rs_stationaryrequests.item_id')
        ->join('rs_locations', 'rs_locations.id', '=', 'rs_stationaryrequests.location_id')
        ->join('rs_costcenters', 'rs_costcenters.id', '=', 'rs_stationaryrequests.costcenter_id')
        ->select('rs_stationaryrequests.id as main_id','users.name as name','users.emp_id as emp_id', 'rs_items.name as item_name', 'rs_items.id as item_id', 'rs_locations.name as loc_name','rs_costcenters.number as cost_center','rs_stationaryrequests.quantity as quantity','rs_stationaryrequests.remarks as remarks',
        'rs_stationaryrequests.pickup_date as p_date','rs_stationaryrequests.updated_at as updt_date',
        'rs_stationaryrequests.time_slot as time_slot')
        ->where('rs_stationaryrequests.status','5')
        ->where('rs_stationaryrequests.issue_status','5')
        ->where('rs_stationaryrequests.location_id',session('location'))
        ->get();
        }
        else
        {
            $issue_requests=null;
        }    

        if($safety_admin)
        {
            $shoes_issue_requests = DB::table('rs_safety_requests')
        ->join('users', 'users.id', '=', 'rs_safety_requests.user_id')
        ->join('rs_safety_shoes', 'rs_safety_shoes.id', '=', 'rs_safety_requests.shoes_id')
        ->join('rs_locations', 'rs_locations.id', '=', 'rs_safety_shoes.location_id')
        ->select('rs_safety_requests.*', 'rs_safety_shoes.brand as brand_name','rs_safety_shoes.size as size','rs_safety_shoes.id as shoes_id','users.name as name','users.emp_id as emps_id','rs_locations.name as loc_name')
        ->where('rs_safety_requests.status','5')
        ->where('rs_safety_requests.issue_status','5')
        ->where('rs_safety_shoes.location_id',session('location'))
        ->get();
        }
        else
        {
            $shoes_issue_requests=null;
        }

        if($hk_admin)
        {
            $hk_issue_requests = DB::table('rs_hkrequests')
        ->join('users', 'users.id', '=', 'rs_hkrequests.user_id')
        ->join('rs_hk_stock', 'rs_hk_stock.id', '=', 'rs_hkrequests.item_id')
        ->join('rs_locations', 'rs_locations.id', '=', 'rs_hk_stock.location_id')
        ->select('rs_hkrequests.id as main_id','users.name as name','users.emp_id as emp_id', 'rs_hk_stock.name as item_name', 'rs_hk_stock.id as item_id', 'rs_locations.name as loc_name','rs_hkrequests.quantity as quantity',
        'rs_hkrequests.pickup_date as p_date','rs_hkrequests.updated_at as updt_date')
        ->where('rs_hkrequests.status','5')
        ->where('rs_hkrequests.issue_status','5')
        ->where('rs_hk_stock.location_id',session('location'))
        ->get();
        }
        else
        {
            $hk_issue_requests=null;
        }

        return view('approvals.issues_approvals')->withIssues($issue_requests)->withShoesissues($shoes_issue_requests)->withHkissues($hk_issue_requests);

        // if($stationary_admin && !$safety_admin)
        // {
        //     $shoes_issue_requests=null;
        //     $issue_requests = DB::table('rs_stationaryrequests')
        // ->join('users', 'users.id', '=', 'rs_stationaryrequests.user_id')
        // ->join('rs_items', 'rs_items.id', '=', 'rs_stationaryrequests.item_id')
        // ->join('rs_locations', 'rs_locations.id', '=', 'rs_stationaryrequests.location_id')
        // ->join('rs_costcenters', 'rs_costcenters.id', '=', 'rs_stationaryrequests.costcenter_id')
        // ->select('rs_stationaryrequests.id as main_id','users.name as name','users.emp_id as emp_id', 'rs_items.name as item_name', 'rs_items.id as item_id', 'rs_locations.name as loc_name','rs_costcenters.number as cost_center','rs_stationaryrequests.quantity as quantity','rs_stationaryrequests.remarks as remarks',
        // 'rs_stationaryrequests.pickup_date as p_date','rs_stationaryrequests.updated_at as updt_date',
        // 'rs_stationaryrequests.time_slot as time_slot')
        // ->where('rs_stationaryrequests.status','5')
        // ->where('rs_stationaryrequests.issue_status','5')
        // ->where('rs_stationaryrequests.location_id',session('location'))
        // ->get();

        // return view('approvals.issues_approvals')->withIssues($issue_requests)->withShoesissues($shoes_issue_requests);
        // }

        // if(!$stationary_admin && $safety_admin)
        // {
        //     $issues=null;
        //     $shoes_issue_requests = DB::table('rs_safety_requests')
        // ->join('users', 'users.id', '=', 'rs_safety_requests.user_id')
        // ->join('rs_safety_shoes', 'rs_safety_shoes.id', '=', 'rs_safety_requests.shoes_id')
        // ->join('rs_locations', 'rs_locations.id', '=', 'rs_safety_shoes.location_id')
        // ->select('rs_safety_requests.*', 'rs_safety_shoes.brand as brand_name','rs_safety_shoes.size as size','rs_safety_shoes.id as shoes_id','users.name as name','users.emp_id as emps_id','rs_locations.name as loc_name')
        // ->where('rs_safety_requests.status','5')
        // ->where('rs_safety_requests.issue_status','5')
        // ->where('rs_safety_shoes.location_id',session('location'))
        // ->get();

        // return view('approvals.issues_approvals')->withShoesissues($shoes_issue_requests)->withIssues($issues);
        // }

        // if($stationary_admin && $safety_admin)
        // {
        //     $issue_requests = DB::table('rs_stationaryrequests')
        // ->join('users', 'users.id', '=', 'rs_stationaryrequests.user_id')
        // ->join('rs_items', 'rs_items.id', '=', 'rs_stationaryrequests.item_id')
        // ->join('rs_locations', 'rs_locations.id', '=', 'rs_stationaryrequests.location_id')
        // ->join('rs_costcenters', 'rs_costcenters.id', '=', 'rs_stationaryrequests.costcenter_id')
        // ->select('rs_stationaryrequests.id as main_id','users.name as name','users.emp_id as emp_id', 'rs_items.name as item_name', 'rs_items.id as item_id', 'rs_locations.name as loc_name','rs_costcenters.number as cost_center','rs_stationaryrequests.quantity as quantity','rs_stationaryrequests.remarks as remarks',
        // 'rs_stationaryrequests.pickup_date as p_date','rs_stationaryrequests.updated_at as updt_date',
        // 'rs_stationaryrequests.time_slot as time_slot')
        // ->where('rs_stationaryrequests.status','5')
        // ->where('rs_stationaryrequests.issue_status','5')
        // ->where('rs_stationaryrequests.location_id',session('location'))
        // ->get();

        // $shoes_issue_requests = DB::table('rs_safety_requests')
        // ->join('users', 'users.id', '=', 'rs_safety_requests.user_id')
        // ->join('rs_safety_shoes', 'rs_safety_shoes.id', '=', 'rs_safety_requests.shoes_id')
        // ->join('rs_locations', 'rs_locations.id', '=', 'rs_safety_shoes.location_id')
        // ->select('rs_safety_requests.*', 'rs_safety_shoes.brand as brand_name','rs_safety_shoes.size as size','users.name as name','users.emp_id as emps_id','rs_locations.name as loc_name')
        // ->where('rs_safety_requests.status','5')
        // ->where('rs_safety_requests.issue_status','5')
        // ->where('rs_safety_shoes.location_id',session('location'))
        // ->get();

        // return view('approvals.issues_approvals')->withIssues($issue_requests)->withShoesissues($shoes_issue_requests);
        // }
        


        
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

            $available =  DB::table('rs_items')
                        ->where('id', $request->item_id)
                        ->value('available');

            $threshold =  DB::table('rs_items')
                        ->where('id', $request->item_id)
                        ->value('threshold');


            if($threshold < $available ){

             $name =  DB::table('rs_items')
                    ->where('id', $request->item_id)
                    ->value('name');

            

             $all_dept = DB::table('rs_location2department')->where('location',session('location'))->get();

            foreach ($all_dept as $eachDept) {

                $user_id = DB::table('rs_admin2modules')->where('module_id','1')->where('department',$eachDept->department)->get();

                    foreach ($user_id as $eachUser) {

                        $admin_email = DB::table('users')->where('id',$eachUser->user_id)->value('email');

                        $mailData = array(
                            'item_name'=>  $name,
                           );
                         \Mail::to($admin_email)->queue(new StationaryThreshold($mailData));
                    }
               
            }

              
            }

            break;

            case 'shoes_issue_request':
            //Updating in the parent table
            DB::table('rs_safety_requests')
                        ->where('id', $request->id)
                        ->update([
                            'status' => 4,
                            'issue_status' => 4,
                            'issued_by' => session('user_id'),
                            'issued_date' => DB::raw('CURRENT_TIMESTAMP')
                        ]);
            
            DB::table('rs_safety_shoes')
                        ->where('id', $request->shoes_id)
                        ->decrement('available',$request->shoes_qty);

            break;

            case 'hk_issue_request':
            //Updating in the parent table
            DB::table('rs_hkrequests')
                        ->where('id', $request->id)
                        ->update([
                            'status' => 4,
                            'issue_status' => 4,
                            'issued_by' => session('user_id'),
                            'issued_date' => DB::raw('CURRENT_TIMESTAMP')
                        ]);
            
            DB::table('rs_hk_stock')
                        ->where('id', $request->item_id)
                        ->decrement('available',$request->item_qty);

            break;

            case 'delete_request':
            rs_stationaryrequests::where('id', $request->id)
                        ->delete();
            break;

            case 'hk_delete_request':
            rs_hkrequests::where('id', $request->id)
                        ->delete();
            break;

            case 'shoes_delete_request':
            rs_safety_requests::where('id', $request->id)
                        ->delete();
            break;

             default:
             $data['success'] = 'false';

            }
        return $data;
        }

    }

}
