<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Session;

use DB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session(['user_id' => Auth::id()]); 

        $location = DB::table('rs_locations')
        ->leftJoin('rs_location2department', 'rs_location2department.location', '=', 'rs_locations.id')
        ->select('rs_locations.*', DB::raw("count(rs_location2department.location) as count"))
        ->groupBy('rs_locations.id')
        ->get();

        $dept2location = DB::table('rs_departments')->select('rs_departments.name as name','rs_departments.id as id','rs_location2department.location as location_id') 
                    ->join('rs_location2department', 'rs_location2department.department', '=', 'rs_departments.id')
                    ->get();

        return view('admin')->withLocation($location)->withDeptlocation($dept2location);
    }
}
