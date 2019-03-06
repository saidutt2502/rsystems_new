<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class IssueController extends Controller
{
    public function issue_request()
    {
      $issues = DB::table('rs_serv_issues')->where('reporter_id',session('user_id'))->get();

      

      return view('issue_tracker.issues')->withIssues($issues);
    }

    public function issue_request_serv()
    {
      $issues = DB::table('rs_serv_issues')->get();

      

      return view('issue_tracker.issues_serv')->withIssues($issues);
    }

    public function issue_requests_form()
    {
      
      $user = DB::table('users')
            ->select('*')
            ->where('id',session('user_id'))
            ->first();
      $department = DB::table('rs_modules_programmer')->get();
                      

      return view('issue_tracker.issue_requests_form')->withUser($user)->withDepartments($department);
    }

    public function forms_issue_functions(Request $request)
    {
    
         DB::table('rs_serv_issues')->insert([
           'remark' => $request->remark, 
           'issue' => $request->issue,
           'reporter_id'=> session('user_id'),
           'department' => $request->dept_id,
           'reported_on' => date("Y-m-d"),
           'status' => '1' ,
           ]);

           return redirect()->action('IssueController@issue_request'); 
   
         }

}
