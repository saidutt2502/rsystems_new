<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApprovalTraits;
use DB;
use Session;



class TaxiController extends Controller
{

  // Included to Get the Higher Up person to send for approval
  use ApprovalTraits;

  public function __construct()
  {
      /* Function to get module ID */
      if(!session('module_id')){
              $dept_id = DB::table('rs_location2department')->where('location',session('location') )->get();

              foreach($dept_id as $each_dept){

                  $correct_dept = DB::table('rs_modules')->where('department', $each_dept->department)->where('name','Taxi')
                  ->first();

                  if($correct_dept){
                      session(['module_id' =>  $correct_dept->id]); 
                      session(['dept_id' =>  $each_dept->department]); 
                  }
          }
      }

  }
   
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
              ->join('rs_costcenters', 'rs_costcenters.id', '=', 'rs_taxi_requests.cc_id')
              ->join('rs_status', 'rs_status.id', '=', 'rs_taxi_requests.status')
              ->select('rs_taxi_requests.*', 'rs_costcenters.number as cc_number','rs_status.html_string as html_status')
              ->where('rs_taxi_requests.user_id',session('user_id'))
              ->get();

      

      return view('taxi.taxi_requests')->withRequests($taxi);
    }

    public function taxi_details()
    {
      $vendors=DB::table('rs_taxi_vendors')->where('location_id',session('location'))->get();
      $airports=DB::table('rs_taxisettings')->where('location_id',session('location'))->first(); 
           

      return view('taxi.taxi_details')->withVendors($vendors)->withAirports($airports);
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

    public function forms_taxi_functions(Request $request)
 {
   if($request->trip_type=='Airport')
   {
     if($request->journey=='Drop')
     {
      $id = DB::table('rs_taxi_requests')->insertGetId([
        'user_id' => $request->user_id, 
        'date_' => $request->date,
        'location'=> $request->location,
        'cc_id' => $request->cc_id,
        'trip_type' => $request->trip_type,
        'purpose' => $request->purpose ,
        'place_from' => $request->place ,
        'place_to' => 'Airport' ,
        'time1' => $request->time ,
        'journey' => $request->journey ,
        'status' => '1' ,
        'location_id'=> session('location'),
        ]);
     }
     else
     {
      $id = DB::table('rs_taxi_requests')->insertGetId([
        'user_id' => $request->user_id, 
        'date_' => $request->date,
        'location'=> $request->location,
        'cc_id' => $request->cc_id,
        'trip_type' => $request->trip_type,
        'purpose' => $request->purpose ,
        'place_from' => 'Airport' ,
        'place_to' => $request->place ,
        'time1' => $request->time ,
        'journey' => $request->journey ,
        'status' => '1' ,
        'location_id'=> session('location'),
        ]);
     }
   }
   else if($request->trip_type=='Local Run')
   {
     if($request->to_time)
     {
      $id = DB::table('rs_taxi_requests')->insertGetId([
        'user_id' => $request->user_id, 
        'date_' => $request->date,
        'location'=> $request->location,
        'cc_id' => $request->cc_id,
        'trip_type' => $request->trip_type,
        'purpose' => $request->purpose ,
        'place_from' => $request->place_from ,
        'place_to' => $request->place_to ,
        'time1' => $request->from_time ,
        'time2' => $request->to_time ,
        'status' => '1' ,
        'location_id'=> session('location'),
        ]);
     }
     else
     {
      $id = DB::table('rs_taxi_requests')->insertGetId([
        'user_id' => $request->user_id, 
        'date_' => $request->date,
        'location'=> $request->location,
        'cc_id' => $request->cc_id,
        'trip_type' => $request->trip_type,
        'purpose' => $request->purpose ,
        'place_from' => $request->place_from ,
        'place_to' => $request->place_to ,
        'time1' => $request->from_time ,
        'status' => '1' ,
        'location_id'=> session('location'),
        ]);
     }
   }
    
                
                
            //Sending for approval (params:costcenter,Insert Id, Table-name)
                $this->get_higher_up($request->cc_id,$id,'rs_taxi_requests');

        return redirect()->action('TaxiController@taxi_requests'); 

        
    
 }

 public function taxi_schedule()
    {
      $taxi = DB::table('rs_taxi_requests')
              ->join('rs_costcenters', 'rs_costcenters.id', '=', 'rs_taxi_requests.cc_id')
              ->join('rs_status', 'rs_status.id', '=', 'rs_taxi_requests.status')
              ->join('users', 'users.id', '=', 'rs_taxi_requests.user_id')
              ->select('rs_taxi_requests.*', 'rs_costcenters.number as cc_number','rs_status.html_string as html_status', 'users.name as name', 'users.emp_id as emp_id')
              ->where('rs_taxi_requests.location',session('location'))
              ->where('rs_taxi_requests.status','2')
              ->get();
              
      $count = DB::table('rs_taxi_requests')
              ->where('location',session('location'))
              ->where('status','2')
              ->count();
      $taxi_no = DB::table('rs_taxi_cars')
                 ->join('rs_taxi_vendors', 'rs_taxi_vendors.id', '=', 'rs_taxi_cars.vendor_id')
                 ->where('rs_taxi_vendors.location_id',session('location'))
                 ->select('rs_taxi_cars.*')
                 ->get();
      $taxi_schedule = DB::table('rs_taxi_schedules')
                       ->join('rs_taxi_requests', 'rs_taxi_requests.id', '=', 'rs_taxi_schedules.lead_trip_id')
                       ->join('rs_taxi_cars', 'rs_taxi_cars.id', '=', 'rs_taxi_schedules.taxi_id')
                       ->where('rs_taxi_requests.location',session('location'))
                       ->where('rs_taxi_requests.status','8')
                       ->select('rs_taxi_schedules.*','rs_taxi_requests.date_ as date_','rs_taxi_requests.place_from as place_from','rs_taxi_requests.place_to as place_to','rs_taxi_cars.taxino as taxino')
                       ->get();
      
      $taxi_costs = DB::table('rs_taxi_schedules')
                    ->join('rs_taxi_requests', 'rs_taxi_requests.id', '=', 'rs_taxi_schedules.lead_trip_id')
                    ->join('rs_taxi_cars', 'rs_taxi_cars.id', '=', 'rs_taxi_schedules.taxi_id')
                    ->join('users', 'users.id', '=', 'rs_taxi_requests.user_id')
                    ->where('rs_taxi_requests.location',session('location'))
                    ->where('rs_taxi_requests.status','7')
                    ->select('rs_taxi_schedules.*','rs_taxi_requests.date_ as date_','rs_taxi_requests.place_from as place_from','rs_taxi_requests.place_to as place_to','rs_taxi_cars.taxino as taxino', 'users.name as name', 'users.emp_id as emp_id')
                    ->get();                 
      
      
                           

      return view('taxi.taxi_schedule')->withRequests($taxi)->withCount($count)->withTaxino($taxi_no)->withTaxischedule($taxi_schedule)->withTaxicosts($taxi_costs);
    }

    public function taxi_closing()
    {

      $taxi_schedule = DB::table('rs_taxi_schedules')
                       ->join('rs_taxi_requests', 'rs_taxi_requests.id', '=', 'rs_taxi_schedules.lead_trip_id')
                       ->join('rs_taxi_cars', 'rs_taxi_cars.id', '=', 'rs_taxi_schedules.taxi_id')
                       ->where('rs_taxi_requests.location',session('location'))
                       ->whereIn('rs_taxi_requests.status',['8','9'])
                       ->select('rs_taxi_schedules.*','rs_taxi_requests.date_ as date_','rs_taxi_requests.place_from as place_from','rs_taxi_requests.place_to as place_to','rs_taxi_requests.status as status','rs_taxi_cars.taxino as taxino')
                       ->get();
                       return view('taxi.taxi_closing')->withTaxischedule($taxi_schedule);
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
                
                foreach($request->airport_locations as $key => $value){
                  if($request->airport_charges[$key] != 0){
                    DB::table('rs_taxi_airports')->insert([
                      'type_id'=> $id,
                      'name'=> $value,
                      'charges'=> $request->airport_charges[$key],
                      'user_id'=> session('user_id'),
                      ]);
                  }
                 }

               $data=1;
                 break;
          
          case 'find_type':

              
                 $type = DB::table('rs_taxi_type')->where('vendor_id',$request->vendor)->get();
                 $count = DB::table('rs_taxi_type')->where('vendor_id',$request->vendor)->count();
                 $data=$type;
                 $data['count']=$count;
                   break;       

          case 'add_car':

               $id = DB::table('rs_taxi_cars')->insert([
                'vendor_id'=> $request->vendor,
                'type_id'=> $request->type,
                'taxino'=> $request->taxino,
                'user_id'=> session('user_id'),
                ]);

               $data=1;
                 break;
          
          case 'assign_taxi':

                 $id = DB::table('rs_taxi_schedules')->insertGetId([
                  'lead_trip_id'=> $request->trip_id,
                  'scheduled_time'=> $request->time,
                  'taxi_id'=> $request->taxino,
                  'assigning_user'=> session('user_id'),
                  ]);

                  DB::table('rs_taxi_requests')
                            ->where('id', $request->trip_id)
                            ->update([
                                'status' => '8', 
                            ]);
                  DB::table('rs_taxi_requests2schedules')->insert([
                              'request_id'=> $request->trip_id,
                              'schedule_id'=> $id,
                              ]);          
  
                 $data=1;
                break;       
          case 'add_trip':

                 DB::table('rs_taxi_requests2schedules')->insert([
                             'request_id'=> $request->request_id,
                             'schedule_id'=> $request->schedule_id,
                             ]);
                DB::table('rs_taxi_requests')
                             ->where('id', $request->request_id)
                             ->update([
                                 'status' => '8', 
                             ]);                      
 
                $data=1;
               break;
            
          case 'start_trip':

          DB::table('rs_taxi_schedules')
          ->where('id', $request->schedule_id)
          ->update([
              'start_date' => $request->start_date,
              'start_time' => $request->start_time,
              'start_km' => $request->start_kms, 
          ]);

          $values=DB::table('rs_taxi_requests2schedules')->where('schedule_id',$request->schedule_id)->get();

          foreach($values as $value)
          {
            DB::table('rs_taxi_requests')
            ->where('id', $value->request_id)
            ->update([
              'status' => '9', 
            ]);
          }
                      

              $data=1;
             break;
             
          case 'close_trip':

            $start_kms = DB::table('rs_taxi_schedules')
            ->where('id', $request->schedule_id)
            ->value('start_km');
            
             if($request->remarks)
             {
             DB::table('rs_taxi_schedules')
             ->where('id', $request->schedule_id)
             ->update([
                 'end_date' => $request->close_date,
                 'end_time' => $request->close_time,
                 'end_km' => $request->close_kms,
                 'total_km' => $request->close_kms-$start_kms,
                 'wait_time' => $request->wait_time,
                 'extra_cost' => $request->extra_costs,
                 'remarks' => $request->remarks,
                 'closing_user' => session('user_id'), 
             ]);
             }
             else
             {
              DB::table('rs_taxi_schedules')
              ->where('id', $request->schedule_id)
              ->update([
                  'end_date' => $request->close_date,
                  'end_time' => $request->close_time,
                  'end_km' => $request->close_kms,
                  'total_km' => $request->close_kms-$start_kms,
                  'wait_time' => $request->wait_time,
                  'extra_cost' => $request->extra_costs,
                  'closing_user' => session('user_id'), 
              ]);
             }
   
             $values=DB::table('rs_taxi_requests2schedules')->where('schedule_id',$request->schedule_id)->get();
   
             foreach($values as $value)
             {
               DB::table('rs_taxi_requests')
               ->where('id', $value->request_id)
               ->update([
                 'status' => '7', 
               ]);
             }

             $scheduled_trip=DB::table('rs_taxi_schedules')->where('id',$request->schedule_id)->first();

             $requested_trip=DB::table('rs_taxi_requests')->where('id',$scheduled_trip->lead_trip_id)->first();
             $next_day=date('Y-m-d ', strtotime($requested_trip->date_ . ' +1 day'));

             $details=DB::table('rs_taxi_schedules')
                      ->join('rs_taxi_cars','rs_taxi_cars.id','=','rs_taxi_schedules.taxi_id')
                      ->join('rs_taxi_type','rs_taxi_type.id','=','rs_taxi_cars.type_id')
                      ->select('rs_taxi_type.*')
                      ->where('rs_taxi_schedules.taxi_id',$scheduled_trip->taxi_id)
                      ->first();
              $taxi_settings=DB::table('rs_taxisettings')->where('location_id',session('location'))->first();        

                      if($requested_trip->trip_type=='Local Run')
                      {
                        //Vendor Taxi Kms Cost
                        if($details->base_cost!='0')
                        {
                          //Total kms less than Base Cost
                          if($scheduled_trip->total_km<=$taxi_settings->base_kms)
                          {
                            $cost = $details->base_cost;
                          }
                          //Total kms greater than Base Cost
                          else
                          {
                            $cost = $details->base_cost+($scheduled_trip->total_km-$taxi_settings->base_kms)*$details->km_cost;
                          }
                        }
                        //Rented Taxi and Company Car Kms Cost
                        if($details->base_cost=='0')
                        {
                          $cost = $scheduled_trip->total_km * $details->km_cost;
                        }

                        //Night Charges
                        if($scheduled_trip->end_time>=$taxi_settings->night_time && $scheduled_trip->end_date==$requested_trip->date_ )
                        {
                          $cost+=$details->night; 
                        }
                        
                        // MidNight Charges
                        // if($scheduled_trip->end_time>=$taxi_settings->midnight_time && $scheduled_trip->end_date==$next_day)
                        // {
                          
                        // } 

                        $cost+=$scheduled_trip->wait_time*$details->waiting;
                        $cost+=$scheduled_trip->extra_cost;
                        
                      }
                      elseif($requested_trip->trip_type=='Airport')
                      {
                        
                      }
         
                      DB::table('rs_taxi_schedules')
                      ->where('id',$request->schedule_id)
                      ->update([
                       'cost' => $cost, 
                      ]);
   
                $data=1;
                break;
                
          case 'validate_trip':

          $values=DB::table('rs_taxi_requests2schedules')->where('schedule_id',$request->trip_id)->get();

          foreach($values as $value)
          {
            DB::table('rs_taxi_requests')
            ->where('id', $value->request_id)
            ->update([
              'status' => '10', 
            ]);
          }
                      

              $data=1;
             break;
            }

          return $data;
      }
  }
  

}