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
      
              

                  $correct_dept = DB::table('rs_modules_programmer')->where('module_name','Taxi')
                  ->first();

                  if($correct_dept){
                      session(['module_id' =>  $correct_dept->id]); 
                      
                  
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
      $cost_center = DB::table('rs_costcenters')
                       ->join('rs_departments', 'rs_costcenters.department', '=', 'rs_departments.id')
                       ->join('rs_location2department', 'rs_location2department.department', '=', 'rs_departments.id')
                       ->join('rs_locations', 'rs_location2department.location', '=', 'rs_locations.id')
                       ->select('rs_locations.name as l_name','rs_costcenters.*')
                       ->get();
      $user = DB::table('users')
            ->select('*')
            ->where('id',session('user_id'))
            ->first();
      $locations =  DB::table('rs_locations')
      ->select('*')
      ->get();
      $airports = DB::table('rs_taxisettings')
            ->where('location_id',session('location'))
            ->value('airport_locations');
                      

      return view('taxi.taxi_requests_form')->withCostcenters($cost_center)->withUser($user)->withLocations($locations)->withAirports($airports);
    }

    public function forms_taxi_functions(Request $request)
 {

  

   $airport_count=DB::table('rs_taxisettings')->where('location_id',session('location'))->value('airport_locations');
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
                 ->select('rs_taxi_cars.*','rs_taxi_vendors.name as v_name')
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

    public function taxi_old_records()
    {
          $taxi_nos = DB::table('rs_taxi_cars')
                       ->join('rs_taxi_vendors', 'rs_taxi_vendors.id', '=', 'rs_taxi_cars.vendor_id')
                       ->where('rs_taxi_vendors.location_id',session('location'))
                        ->select('rs_taxi_cars.*')
                       ->get();           

                     
          return view('taxi.taxi_old_records_dates')->withTaxinos($taxi_nos);
    }

    public function taxi_old_records_view(Request $request)
 {

  
    $records=DB::table('taxitrip')
            ->join('users','users.emp_id','=','taxitrip.lead')
            ->where('taxitrip.taxino',$request->taxino)
            ->where('taxitrip.ddate','>=',$request->from)
            ->where('taxitrip.ddate','<=',$request->to)
            ->select('taxitrip.*','users.name as name')
            ->get();
    $total=DB::table('taxitrip')
            ->join('users','users.emp_id','=','taxitrip.lead')
            ->where('taxitrip.taxino',$request->taxino)
            ->where('taxitrip.ddate','>=',$request->from)
            ->where('taxitrip.ddate','<=',$request->to)
            ->sum('taxitrip.cost');
    $kms=DB::table('taxitrip')
            ->join('users','users.emp_id','=','taxitrip.lead')
            ->where('taxitrip.taxino',$request->taxino)
            ->where('taxitrip.ddate','>=',$request->from)
            ->where('taxitrip.ddate','<=',$request->to)
            ->sum('taxitrip.totalkm');                         
  
    return view('taxi.taxi_old_records_view')->withRecords($records)->withTotal($total)->withKms($kms)->withKms($kms);

       

    
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

              
               $id = DB::table('rs_taxi_type')->insertGetId([
                'vendor_id'=> $request->vendor,
                'type'=> $request->type,
                'base_cost'=> $request->base_kms,
                'km_cost'=> $request->per_km,
                'night'=> $request->night,
                'midnight'=> $request->midnight,
                'waiting'=> $request->wait,
                'user_id'=> session('user_id'),
                ]);
                if($request->airport_locations)
                {
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
               
          case 'get_airports':

                 $airports=DB::table('rs_taxisettings')->where('location_id',session('location'))->value('airport_locations');
                 $i=0;

                 foreach(explode(',', $airports) as $airport)
                 {
                   $data[$i]=$airport;
                   $i++;
                 }
                 $data['count']=$i;
                   break;
          case 'delete_taxi_request':

                   DB::table('rs_taxi_requests')->where('id', $request->trip_id)->delete();                                              
   
                  $data=1;
                 break;                
          
          case 'assign_taxi':

                 if($request->trip_type=='Complete')
                 {
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
                 }
                 else
                 {
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
                    
                    $details = DB::table('rs_taxi_requests')->where('id', $request->trip_id)->first();

                    DB::table('rs_taxi_requests')->insert([
                     'user_id' => $details->user_id, 
                     'date_' => $details->date_,
                     'location'=> $details->location,
                     'cc_id' => $details->cc_id,
                     'trip_type' => $details->trip_type,
                     'purpose' => $details->purpose ,
                     'place_from' => $details->place_to ,
                     'place_to' => $details->place_from ,
                     'time1' => $details->time2 ,
                     'status' => '2' ,
                     'location_id'=> $details->location_id,
                      ]);
              

                 }          
  
                 $data=1;
                break;
                
                case 'unassign_taxi':

                $request2schedule_entries=DB::table('rs_taxi_requests2schedules')->where('schedule_id',$request->schedule_id)->get();

                foreach($request2schedule_entries as $each_entry)
                {
                  DB::table('rs_taxi_requests')
                              ->where('id', $each_entry->request_id)
                              ->update([
                                  'status' => '2', 
                              ]);
                  DB::table('rs_taxi_requests2schedules')->where('request_id', $each_entry->request_id)->delete();            
                }

                DB::table('rs_taxi_schedules')->where('id', $request->schedule_id)->delete();                                              

               $data=1;
              break;

              // case 'unassign_single_trip':

              // $schedules=DB::table('rs_taxi_schedules')->where('id',$request->schedule_id)->first();
              // $count=DB::table('rs_taxi_requests2schedules')->where('schedule_id', $request->schedule_id)->count('id');

              // if($count==1)
              // {}
              // else
              // {
              //    // Check if Lead
              // if($schedules->lead_trip_id==$request->request_id)
              // {
              //   $request2schedule_entries=DB::table('rs_taxi_requests2schedules')->where('schedule_id',$request->schedule_id)->get();

              //   foreach($request2schedule_entries as $each_entry)
              //   {
              //     DB::table('rs_taxi_requests')
              //                 ->where('id', $each_entry->request_id)
              //                 ->update([
              //                     'status' => '2', 
              //                 ]);
              //     DB::table('rs_taxi_requests2schedules')->where('request_id', $each_entry->request_id)->delete();            
              //   }

              //   DB::table('rs_taxi_schedules')->where('id', $request->schedule_id)->delete(); 
              // }
              // else
              // {
              //   $request2schedule_entries=DB::table('rs_taxi_requests2schedules')->where('request_id',$request->id)->delete();
              //   DB::table('rs_taxi_requests')
              //                 ->where('id', $request->request_id)
              //                 ->update([
              //                     'status' => '2', 
              //                 ]);
              // } 
              // }
              

              //  $data=1;
              // break;

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

          case 'update_lead_passenger':

          $schedule_id=DB::table('rs_taxi_requests2schedules')->where('request_id',$request->request_id)->value('schedule_id');

          DB::table('rs_taxi_schedules')
                           ->where('id', $schedule_id)
                           ->update([
                               'lead_trip_id' => $request->request_id, 
                           ]);                      

              $data=$request->request_id;
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
             $next_day=date('Y-m-d',strtotime('+1 day',strtotime($requested_trip->date_)));

             $details=DB::table('rs_taxi_schedules')
                      ->join('rs_taxi_cars','rs_taxi_cars.id','=','rs_taxi_schedules.taxi_id')
                      ->join('rs_taxi_type','rs_taxi_type.id','=','rs_taxi_cars.type_id')
                      ->select('rs_taxi_type.*')
                      ->where('rs_taxi_schedules.taxi_id',$scheduled_trip->taxi_id)
                      ->first();
              $taxi_settings=DB::table('rs_taxisettings')->where('location_id',session('location'))->first();
              
              $morning_midnight_count=DB::table('rs_taxi_schedules')->where('taxi_id',$scheduled_trip->taxi_id)->where('start_date',$requested_trip->date_)->where('midnight','1')->count();
              $night_count=DB::table('rs_taxi_schedules')->where('taxi_id',$scheduled_trip->taxi_id)->where('end_date',$requested_trip->date_)->where('night','1')->count();
              $midnight_count=DB::table('rs_taxi_schedules')->where('taxi_id',$scheduled_trip->taxi_id)->where('end_date',$next_day)->where('midnight','1')->count();
             

                      // if($requested_trip->trip_type=='Local Run')
                      // {
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


                        // Morning MidNight Charges
                        if($scheduled_trip->start_time>=$taxi_settings->midnight_time && $scheduled_trip->start_time<$taxi_settings->day_time && $scheduled_trip->start_date==$requested_trip->date_ && $morning_midnight_count=='0')
                        {
                          $cost+=$details->midnight;
                          DB::table('rs_taxi_schedules')
                          ->where('id', $request->schedule_id)
                          ->update([
                           'midnight' => '1',
                          ]);
                        }

                        //Night Charges
                        if($scheduled_trip->end_time>=$taxi_settings->night_time && $scheduled_trip->end_date==$requested_trip->date_ && $night_count=='0' )
                        {
                          $cost+=$details->night;
                          DB::table('rs_taxi_schedules')
                          ->where('id', $request->schedule_id)
                          ->update([
                           'night' => '1',
                          ]);
                        }
                        
                        // MidNight Charges
                        if($scheduled_trip->end_time>=$taxi_settings->midnight_time && $scheduled_trip->end_date==$next_day && $midnight_count=='0')
                        {
                          if($night_count!='0' && $details->midnight!='0')
                          {
                            $totalcost=DB::table('rs_taxi_schedules')->where('taxi_id',$scheduled_trip->taxi_id)->where('end_date',$requested_trip->date_)->where('night','1')->value('cost');
                            $night_trip=DB::table('rs_taxi_schedules')->where('taxi_id',$scheduled_trip->taxi_id)->where('end_date',$requested_trip->date_)->where('night','1')->update([
                              'night' => '0',
                              'cost' => $totalcost-$details->night,
                             ]);
                             DB::table('rs_taxi_schedules')
                             ->where('id', $request->schedule_id)
                             ->update([
                              'midnight' => '1',
                             ]);
                          }
                          $cost+=$details->midnight;
                        }

                        $cost+=$scheduled_trip->wait_time*$details->waiting;
                        $cost+=$scheduled_trip->extra_cost;
                        
                      // }
                      // elseif($requested_trip->trip_type=='Airport')
                      // {
                       
                      // }
         
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

          case 'get_trip_schedule':

             $data=DB::table('rs_taxi_schedules')->where('id',$request->trip_id)->get();
             break;

          case 'edit_trip_schedule':

          DB::table('rs_taxi_schedules')
          ->where('id', $request->trip_id)
          ->update([

              'start_date' => $request->start_date,
              'start_time' => $request->start_time,
              'start_km' => $request->start_kms,
              'end_date' => $request->close_date,
              'end_time' => $request->close_time,
              'end_km' => $request->close_kms,
              'total_km' => $request->close_kms-$request->start_kms,
              'wait_time' => $request->wait_time,
              'extra_cost' => $request->extra_costs,
              'remarks' => $request->remarks,
              'closing_user' => session('user_id'), 
          ]);

          $scheduled_trip=DB::table('rs_taxi_schedules')->where('id',$request->trip_id)->first();

          $requested_trip=DB::table('rs_taxi_requests')->where('id',$scheduled_trip->lead_trip_id)->first();
          $next_day=date('Y-m-d',strtotime('+1 day',strtotime($requested_trip->date_)));

             $details=DB::table('rs_taxi_schedules')
                      ->join('rs_taxi_cars','rs_taxi_cars.id','=','rs_taxi_schedules.taxi_id')
                      ->join('rs_taxi_type','rs_taxi_type.id','=','rs_taxi_cars.type_id')
                      ->select('rs_taxi_type.*')
                      ->where('rs_taxi_schedules.taxi_id',$scheduled_trip->taxi_id)
                      ->first();
              $taxi_settings=DB::table('rs_taxisettings')->where('location_id',session('location'))->first();
              
              $morning_midnight_count=DB::table('rs_taxi_schedules')->where('taxi_id',$scheduled_trip->taxi_id)->where('start_date',$requested_trip->date_)->where('midnight','1')->count();
              $night_count=DB::table('rs_taxi_schedules')->where('taxi_id',$scheduled_trip->taxi_id)->where('end_date',$requested_trip->date_)->where('night','1')->count();
              $midnight_count=DB::table('rs_taxi_schedules')->where('taxi_id',$scheduled_trip->taxi_id)->where('end_date',$next_day)->where('midnight','1')->count();
             

                      // if($requested_trip->trip_type=='Local Run')
                      // {
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


                        // Morning MidNight Charges
                        if($scheduled_trip->start_time>=$taxi_settings->midnight_time && $scheduled_trip->start_time<$taxi_settings->day_time && $scheduled_trip->start_date==$requested_trip->date_ && $morning_midnight_count=='0')
                        {
                          $cost+=$details->midnight;
                          DB::table('rs_taxi_schedules')
                          ->where('id', $request->schedule_id)
                          ->update([
                           'midnight' => '1',
                          ]);
                        }

                        //Night Charges
                        if($scheduled_trip->end_time>=$taxi_settings->night_time && $scheduled_trip->end_date==$requested_trip->date_ && $night_count=='0' )
                        {
                          $cost+=$details->night;
                          DB::table('rs_taxi_schedules')
                          ->where('id', $request->schedule_id)
                          ->update([
                           'night' => '1',
                          ]);
                        }
                        
                        // MidNight Charges
                        if($scheduled_trip->end_time>=$taxi_settings->midnight_time && $scheduled_trip->end_date==$next_day && $midnight_count=='0')
                        {
                          if($night_count!='0' && $details->midnight!='0')
                          {
                            $totalcost=DB::table('rs_taxi_schedules')->where('taxi_id',$scheduled_trip->taxi_id)->where('end_date',$requested_trip->date_)->where('night','1')->value('cost');
                            $night_trip=DB::table('rs_taxi_schedules')->where('taxi_id',$scheduled_trip->taxi_id)->where('end_date',$requested_trip->date_)->where('night','1')->update([
                              'night' => '0',
                              'cost' => $totalcost-$details->night,
                             ]);
                             DB::table('rs_taxi_schedules')
                             ->where('id', $request->schedule_id)
                             ->update([
                              'midnight' => '1',
                             ]);
                          }
                          $cost+=$details->midnight;
                        }

                        $cost+=$scheduled_trip->wait_time*$details->waiting;
                        $cost+=$scheduled_trip->extra_cost;
                        
                      // }
                      // elseif($requested_trip->trip_type=='Airport')
                      // {
                       
                      // }
      
                   DB::table('rs_taxi_schedules')
                   ->where('id',$request->trip_id)
                   ->update([
                    'cost' => $cost, 
                   ]);

             $data=1;
             break;

             case 'delete_taxi_list':
              DB::table($request->table)->where('id', $request->id)->delete();
              $data=1;
                break;

             case 'find_taxi_number':
              
             $type = DB::table('rs_taxi_cars')->where('vendor_id',$request->vendor)->get();
             $count = DB::table('rs_taxi_cars')->where('vendor_id',$request->vendor)->count();
             $data=$type;
             $data['count']=$count;

                break;

            }

          return $data;
      }
  }
  

}