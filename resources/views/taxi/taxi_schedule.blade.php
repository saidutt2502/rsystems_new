@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Taxi</li>
@endsection


@section('page-header')
    <h1>Taxi
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Schedule and Validation</small>
    </h1>
@endsection

@section('main-content')
<div class="row">
    <div class="col-sm-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li id="home_tab_first">
                    <a data-toggle="tab" href="#schedule_taxi">
                        Schedule Taxi
                        <span class="badge badge-danger">{{$count}}</span>
                    </a>
                </li>

                <li>
                    <a data-toggle="tab" href="#view_schedule">
                        View Taxi Schedule
                    </a>
                </li>

                <li>
                    <a data-toggle="tab" href="#cost_validation">
                         Cost Validation
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="schedule_taxi" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-xs-12">
                        @if($requests)
                            @foreach($requests as $each_request)        
                            <div class="media search-media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object" data-src="holder.js/72x72" alt="72x72" style="width: 72px; height: 72px;" src="/core/images/avatars/avatar2.png" data-holder-rendered="true">
                                    </a>
                                </div>

                                <div class="media-body">
                                             <div>
                                                    <h4 class="media-heading">
                                                        <a href="#" class="blue">Taxi&nbsp;&nbsp;|&nbsp;&nbsp;Request</a>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ date("D, d F Y",strtotime($each_request->date_))}}</span>
                                                    </h4>
                                                </div>
                                                    <p>
                                                    User:&nbsp;<b>{{$each_request->name}}&nbsp;(Employee Code:&nbsp;{{$each_request->emp_id}})</b>&nbsp;&nbsp;|&nbsp;&nbsp;From:&nbsp;<b>{{$each_request->place_from}}</b>&nbsp;&nbsp;To:&nbsp;<b>{{$each_request->place_to}}</b>&nbsp;&nbsp;<br>
                                                    Departure from {{$each_request->place_from}}:&nbsp;<b>{{$each_request->time1}} </b><br>
                                                    Departure from {{$each_request->place_to}}:&nbsp;<b>@if($each_request->time2 != null){{$each_request->time2}}@else - @endif </b><br>
                                                    Purpose:&nbsp;<b>{{$each_request->purpose}}</b>
                                                    </p>
                                    <div class="search-actions text-center">
                                        <br>
                                        <a class="btn btn-sm btn-block btn-info assign-btn" data-uniqueID="{{$each_request->id}}">Assign!</a><br><br>
                                        <a class="btn btn-sm btn-block btn-danger delete-btn" data-uniqueID="{{$each_request->id}}">Delete!</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif 
                        </div>
                    </div>
                </div>

<!-- View Taxi Schedule here -->
                <div id="view_schedule" class="tab-pane fade">
                <div class="row">
                        <div class="col-xs-12">
                        <table id="simple-table" class="table  table-bordered table-hover">
    <thead>
    <tr>
        <th class="detail-col">Details</th>
        <th>Date</th>
        <th>Taxi</th>
        <th>From</th>
        <th>To</th>
        <th>Scheduled Time</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @if($taxischedule)
        @foreach($taxischedule as $schedule)
        <tr>
            <td class="center">
                <div class="action-buttons">
                    <a href="#" class="green bigger-140 show-details-btn" title="Show Details">
                        <i class="ace-icon fa fa-angle-double-down"></i>
                        <span class="sr-only">Details</span>
                    </a>
                </div>
            </td>
            <td>
                <a href="#!">{{ date("D, d F Y",strtotime($schedule->date_))}}</a>
            </td>
            <td>
                <a href="#!">{{$schedule->taxino}}</a>
            </td>
            <td><a href="#!">{{$schedule->place_from}}</a></td>
            <td><a href="#!">{{$schedule->place_to}}</a></td>
            <td><a href="#!">{{$schedule->scheduled_time}}</a></td>
            <td><div class="search-actions text-center"><a class="btn btn-sm btn-block btn-danger unassign-btn" data-uniqueID="{{$schedule->id}}">Unassign!</a> </div></td>

        </tr>
        <tr class="detail-row">
            <td colspan="8">

                <div class="input-group col-sm-7  col-sm-offset-2 hidden-480">
                    <select class="chosen-container chosen-container-single chosen-select trip_to_add">
                        <option value="" disabled selected>Select Trip</option>
                            @foreach($requests as $each_request)
                            <option value="{{$each_request->id}}">{{ date("D, d F Y",strtotime($each_request->date_))}},&nbsp;&nbsp;&nbsp;&nbsp;{{$each_request->name}},&nbsp;&nbsp;&nbsp;&nbsp;{{$each_request->place_from}}&nbsp;To&nbsp;{{$each_request->place_to}},&nbsp;&nbsp;&nbsp;&nbsp;{{$each_request->time1}}&nbsp;To&nbsp;@if($each_request->time2){{$each_request->time2}}@else *No Return* @endif</option>
                            @endforeach
                    </select>
                </div><br>

                <div class="input-group col-sm-7  col-sm-offset-5 hidden-480">
                <button type="button" class="btn btn-purple btn-xs add_trip" scheduled-trip="{{$schedule->id}}">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="ace-icon fa fa-check icon-on-right bigger-110"></span>
                    Add&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </button>
                </div><br>
                <?php
                  $passengerdetails = DB::table('rs_taxi_schedules')
                                      ->join('rs_taxi_requests2schedules','rs_taxi_requests2schedules.schedule_id','=','rs_taxi_schedules.id')
                                      ->join('rs_taxi_requests','rs_taxi_requests2schedules.request_id','=','rs_taxi_requests.id')
                                      ->join('users', 'users.id', '=', 'rs_taxi_requests.user_id')
                                      ->where('rs_taxi_schedules.id',$schedule->id)
                                      ->select('rs_taxi_requests.*', 'users.name as name', 'users.emp_id as emp_id')
                                      ->get();                  
                ?>
                @if($passengerdetails)
                    @foreach($passengerdetails as $passengerdetail)
                                    <div class="col-xs-12 col-sm-7 col-sm-offset-2 ">
                                        <div class="col-xs-12 col-sm-12 col-md-12 widget-container-col ui-sortable" id="widget-container-col-3">
                                            <div class="widget-box collapsed ui-sortable-handle" id="widget-box-3">
                                                <div class="widget-header widget-header-small">
                                                    <h6 class="widget-title each_dept_name"><b>Name:</b> {{$passengerdetail->name}} (Emp Id:{{$passengerdetail->emp_id}})<br><b>Place:</b> {{$passengerdetail->place_from}} To {{$passengerdetail->place_to}}</h6>
                                                    <div class="widget-toolbar hidden-480">
                                                        @if($schedule->lead_trip_id==$passengerdetail->id)
                                                        <a href="#"><input type="radio" name="lead_{{$schedule->id}}" value="{{$passengerdetail->id}}" checked></a>
                                                        @else
                                                        <a href="#"><input type="radio" name="lead_{{$schedule->id}}" value="{{$passengerdetail->id}}" ></a>
                                                        @endif
                                                        <!-- <a data-action="close" class="delete_list"  request-id="{{$passengerdetail->id}}" schedule-id="{{$schedule->id}}"><i class="ace-icon fa fa-times"></i></a> -->
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    @endforeach
                @endif
                
                <div class="input-group col-sm-7  col-sm-offset-5 hidden-480">
                <br>
                <input type="button" class="confirm_lead" schedule-id="{{$schedule->id}}" value="Confirm Lead">
                </div>      
            </td>
        </tr>
        @endforeach
    @endif
    </tbody>
</table>
                        </div>
                </div>
            </div>

 
<!-- Cost Validation here -->
<div id="cost_validation" class="tab-pane fade in">
                    <div class="row">
                        <div class="col-xs-12">
                        @if($taxicosts)
                            @foreach($taxicosts as $taxicost)        
                            <div class="media search-media">
                                

                                <div class="media-body">
                                             <div>
                                                    <h4 class="media-heading">
                                                        <a href="#" class="blue">Taxi&nbsp;&nbsp;|&nbsp;&nbsp;Cost Validation</a>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ date("D, d F Y",strtotime($taxicost->date_))}}</span>
                                                    </h4>
                                                </div>
                                                    <p>
                                                    User:&nbsp;<b>{{$taxicost->name}}&nbsp;(Employee Code:&nbsp;{{$taxicost->emp_id}})</b>&nbsp;&nbsp;|Taxi:&nbsp;<b>{{$taxicost->taxino}}</b>&nbsp;&nbsp;|&nbsp;&nbsp;From:&nbsp;<b>{{$taxicost->place_from}}</b>&nbsp;&nbsp;To:&nbsp;<b>{{$taxicost->place_to}}</b>&nbsp;&nbsp;<br>
                                                    Starting Date:&nbsp;<b>{{$taxicost->start_date}}</b>&nbsp;&nbsp;Closing Date:&nbsp;<b>{{$taxicost->end_date}}</b>&nbsp;&nbsp;|&nbsp;&nbsp;Starting Time:&nbsp;<b>{{$taxicost->start_time}}</b>&nbsp;&nbsp;Closing Time:&nbsp;<b>{{$taxicost->end_time}}</b>&nbsp;&nbsp;<br>
                                                    Starting Kms:&nbsp;<b>{{$taxicost->start_km}}</b>&nbsp;&nbsp;Closing Kms:&nbsp;<b>{{$taxicost->end_km}}</b>&nbsp;&nbsp;Total Kms:&nbsp;<b>{{$taxicost->total_km}}</b>&nbsp;&nbsp;|&nbsp;&nbsp;Remarks:&nbsp;<b>{{$taxicost->remarks}}</b><br>
                                                    Wait Time:&nbsp;<b>{{$taxicost->wait_time}} Hrs</b>&nbsp;&nbsp;|&nbsp;&nbsp;Extra Costs:&nbsp;<b>{{$taxicost->extra_cost}}</b>|&nbsp;&nbsp;Total Cost:&nbsp;<b>{{$taxicost->cost}}</b><br>
                                                    </p>
                                    <div class="search-actions text-center">
                                        <br>
                                        <a class="btn btn-sm btn-block btn-success validate-btn" data-validate="{{$taxicost->id}}">Validate!</a><br><br>
                                        <a class="btn btn-sm btn-block btn-info edit-btn" data-edit="{{$taxicost->id}}">Edit!</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif 
                        </div>
                    </div>
                </div>

            
            </div>
        </div>
    </div>
</div>


<!-- Schedule Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
 <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Schedule Taxi</h4>
      </div>
      <div class="modal-body">
      <input class="form-control" type="hidden" id="trip_id">
      <div class="input-group col-sm-12">
      <input type="radio" name="type_of_trip" value="Complete" checked> Complete-Trip</input>&nbsp;&nbsp;
     
      <input type="radio" name="type_of_trip" value="Duration"> Duration-Trip</input>
      
      </div>
      <br><br><br>
      <div class="input-group col-sm-12">
        <select id="taxino" class="chosen-container chosen-container-single chosen-select">
                        <option value="" disabled selected>Select Taxi</option>
                            @foreach($taxino as $each_taxino)
                            <?php
                            $type=DB::table('rs_taxi_type')->where('id',$each_taxino->type_id)->value('type');
                            ?>
                            <option value="{{$each_taxino->id}}">{{$each_taxino->taxino}}  ({{$each_taxino->v_name}} : {{$type}})</option>
                            @endforeach
                    </select>
      </div>
      <br><br><br>
      <div class="input-group col-sm-12">
      <span class="input-group-addon"><i class="ace-icon fa fa-clock-o"></i></span>
      <input class="form-control" type="time" id="time">
      </div>
      *the above field indicates the scheduled time.
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="confirm_assign">Assign</button>
      </div>
    </div>

  </div>
</div>

<!--  Validation Modal -->
<div id="myModal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
 <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Trip Details</h4>
      </div>
      <div class="modal-body">
      <input class="form-control" type="hidden" id="schedule_id">
      <label>Start Date</label>
      <div class="input-group col-sm-12">
      <span class="input-group-addon"><i class="ace-icon fa fa-calendar"></i></span>
      <input class="form-control" type="date" id="start_date"> 
      </div>
      <br><br><br>
      <label>Closing Date</label>
      <div class="input-group col-sm-12">
      <span class="input-group-addon"><i class="ace-icon fa fa-calendar"></i></span>
      <input class="form-control" type="date" id="date_close"> 
      </div>
      <br><br><br>
      <label>Start Time</label>
      <div class="input-group col-sm-12">
      <span class="input-group-addon"><i class="ace-icon fa fa-clock-o"></i></span>
      <input class="form-control" type="time" id="start_time"> 
      </div>
      <br><br><br>    
      <label>Closing Time</label>
      <div class="input-group col-sm-12">
      <span class="input-group-addon"><i class="ace-icon fa fa-clock-o"></i></span>
      <input class="form-control" type="time" id="time_close"> 
      </div>
      <br><br><br>
      <label>Start Kms</label>
      <div class="input-group col-sm-12">
      <span class="input-group-addon"><i class="ace-icon fa fa-road"></i></span>
      <input class="form-control" type="text" id="start_kms">
      </div>
      <br><br><br>
      <label>Closing Kms</label>
      <div class="input-group col-sm-12">
      <span class="input-group-addon"><i class="ace-icon fa fa-road"></i></span>
      <input class="form-control" type="text" id="close_kms">
      </div>
      <br><br><br>
      <label>Waiting Time (Hrs)</label>
      <div class="input-group col-sm-12">
      <span class="input-group-addon"><i class="ace-icon fa fa-clock-o"></i></span>
      <input class="form-control" type="text" id="wait_time"> 
      </div>
      <br><br><br>
      <label>Extra Costs</label>
      <div class="input-group col-sm-12">
      <span class="input-group-addon"><i class="ace-icon fa fa-rupee"></i></span>
      <input class="form-control" type="text" id="extra_costs"> 
      </div>
      <br><br><br>
      <label>Remarks</label>
      <div class="input-group col-sm-12">
      <span class="input-group-addon"><i class="ace-icon fa fa-pencil-square-o"></i></span>
      <textarea class="form-control" type="text" placeholder="Optional" id="remarks"></textarea>
      </div>
      <br><br><br><br>
      *If extra costs is modified state reason explaining why
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="confirm_finish">Finish</button>
      </div>
    </div>

  </div>
</div>


<!-- Validate Modal -->
<div class="modal fade" id="myModal_validate" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Validate Taxi Trip</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to validate this trip?</p>
        <input class="form-control" type="hidden" id="trip_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" id="confirm_validation" class="btn btn-success">Validate</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->

<div class="modal fade" id="DeleteModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Delete Taxi Request</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this request?</p>
        <input class="form-control" type="hidden" id="trip_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" id="confirm_delete" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- Unassign Modal -->
<div class="modal fade" id="UnassignModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Unassign Taxi </h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to unassign this trip?</p>
        <input class="form-control" type="hidden" id="schedule_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" id="confirm_unassign" class="btn btn-danger">Unassign</button>
      </div>
    </div>
  </div>
</div>


    
<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('taxi-ajax')}}" id="url_ajax">

@endsection

@section('js-files')
        <script src="{{ asset('taxi/taxi_schedule.js') }}" defer></script>
@endsection