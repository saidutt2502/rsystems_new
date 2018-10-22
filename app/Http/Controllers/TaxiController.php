<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApprovalTraits;
use DB;



class TaxiController extends Controller
{
   
    public function taxi_settings()
    {
      $taxi_settings = DB::table('rs_taxisettings')
            ->select('*')
            ->where('location_id',session('location'))
            ->first();

      return view('taxi.taxi_settings')->withTaxisettings($taxi_settings);
    }

    public function taxi_requests()
    {
      $taxi = DB::table('rs_taxi_requests')
            ->select('*')
            ->where('user_id',session('user_id'))
            ->get();

      return view('taxi.taxi_requests')->withRequests($taxi);
    }

    public function taxi_requests_form()
    {
      $cc = DB::table('rs_costcenters')
            ->select('*')
            ->get();
      $user = DB::table('users')
            ->select('*')
            ->where('id',session('user_id'))
            ->first();
      $locations =  DB::table('rs_locations')
      ->select('*')
      ->get();          

      return view('taxi.taxi_requests_form')->withCostcenters($cc)->withUser($user)->withLocations($locations);
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
                'night_time' => $request->nightTime,
                'midnight_time' =>$request->midnightTime,
                'airport_locations' =>$request->airportLocations,
                ]);

               $data=1;
                 break;

          case 'add_vendor':

               $id = DB::table('rs_taxi_vendors')->insert([
                'location_id' => session('location'), 
                'user_id' => session('user_id'),
                'name'=> $request->vendor_name,
                ]);

               $data=1;
                 break;
          
          case 'add_type':

               $id = DB::table('rs_taxi_type')->insert([
                'vendor_id'=> $request->vendor,
                'type'=> $request->type,
                'base_cost'=> $request->base_kms,
                'km_cost'=> $request->per_km,
                'night'=> $request->night,
                'midnight'=> $request->midnight,
                'waiting'=> $request->wait,
                'user_id'=> session('user_id'),
                ]);

               $data=1;
                 break;

            }

          return $data;
      }
  }
  

}