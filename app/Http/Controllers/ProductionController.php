<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApprovalTraits;
use DB;
use Session;



class ProductionController extends Controller
{

  
   
    public function index()
    {
      return view('production.add_production');
    }

   


      // Ajax Calls 
  public function ajax_taxi_controller(Request $request)
  {
      if($request->ajax()){

        switch ($request->function_name) {

          case 'edit_taxi_details':

              DB::table('rs_taxisettings')->where('location_id', session('location'))->delete();

               $id = DB::table('rs_taxisettings')->insertGetId([
                'location_id' => session('location'), 
                'user_id' => session('user_id'),
                'base_kms'=> $request->basekms,
                'day_time' => $request->dayTime,
                'night_time' => $request->nightTime,
                'midnight_time' =>$request->midnightTime,
                'airport_locations' =>$request->airportLocations,
                ]);

               $data=1;
                 break;

            }

          return $data;
      }
  }
  

}