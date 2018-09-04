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
        ->where('rs_approvals.status','1')
        ->orderBy('rs_approvals.updated_at','desc')
        ->get();

        $count_approvals = DB::table('rs_approvals')
                                    ->where('user_id',session('user_id'))
                                    ->where('status','1')
                                    ->count();

        $declined_request = DB::table('rs_approvals')
        ->join('rs_modules','rs_modules.id','=','rs_approvals.module_id')
        ->select('rs_approvals.*', 'rs_modules.name as module_name')
        ->where('rs_approvals.user_id',session('user_id'))
        ->where('rs_approvals.status','2')
        ->orderBy('rs_approvals.updated_at','desc')
        ->get();

        return view('approvals.index')->withApprove($approve_requests)->withDecline($declined_request)->withCount($count_approvals);
    }

}