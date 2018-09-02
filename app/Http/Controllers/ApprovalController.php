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
        ->get();

        return view('approvals.index')->withApprove($approve_requests);
    }

}
