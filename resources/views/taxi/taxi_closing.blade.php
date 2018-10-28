@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Taxi</li>
@endsection


@section('page-header')
    <h1>Taxi
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Closing</small>
    </h1>
@endsection

@section('main-content')

 
  <br>

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
            @if($schedule->status=='8')
            <td><div class="search-actions text-center"><a class="btn btn-sm btn-block btn-primary start-btn" data-uniqueID="{{$schedule->id}}" >Start Trip!</a> </div></td>
            @endif
            @if($schedule->status=='9')
            <td><div class="search-actions text-center"><a class="btn btn-sm btn-block btn-danger close-btn" data-uniqueID="{{$schedule->id}}" >Close Trip!</a> </div></td>
            @endif
        </tr>
        <tr class="detail-row">
            <td colspan="8">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    @endforeach
                @endif      
            </td>
        </tr>
        @endforeach
    @endif
    </tbody>
</table>

<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('taxi-ajax')}}" id="url_ajax">

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
 <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Start Details</h4>
      </div>
      <div class="modal-body">
      <input class="form-control" type="hidden" id="schedule_id">
      <label>Start Date</label>
      <div class="input-group col-sm-12">
      <span class="input-group-addon"><i class="ace-icon fa fa-calendar"></i></span>
      <input class="form-control" type="date" id="date"> 
      </div>
      <br><br><br>
      <label>Start Time</label>
      <div class="input-group col-sm-12">
      <span class="input-group-addon"><i class="ace-icon fa fa-clock-o"></i></span>
      <input class="form-control" type="time" id="time"> 
      </div>
      <br><br><br>
      <label>Start Kms</label>
      <div class="input-group col-sm-12">
      <span class="input-group-addon"><i class="ace-icon fa fa-road"></i></span>
      <input class="form-control" type="text" id="start_kms">
      </div>
      <br><br><br>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="confirm_start">Start</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="myModal_close" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
 <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Closing Details</h4>
      </div>
      <div class="modal-body">
      <input class="form-control" type="hidden" id="schedule_id_close">
      <label>Closing Date</label>
      <div class="input-group col-sm-12">
      <span class="input-group-addon"><i class="ace-icon fa fa-calendar"></i></span>
      <input class="form-control" type="date" id="date_close"> 
      </div>
      <br><br><br>
      <label>Closing Time</label>
      <div class="input-group col-sm-12">
      <span class="input-group-addon"><i class="ace-icon fa fa-clock-o"></i></span>
      <input class="form-control" type="time" id="time_close"> 
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
      <input class="form-control" type="text" id="wait_time" value="0"> 
      </div>
      <br><br><br>
      <label>Extra Costs</label>
      <div class="input-group col-sm-12">
      <span class="input-group-addon"><i class="ace-icon fa fa-rupee"></i></span>
      <input class="form-control" type="text" id="extra_costs" value="0"> 
      </div>
      <br><br><br>
      <label>Remarks</label>
      <div class="input-group col-sm-12">
      <span class="input-group-addon"><i class="ace-icon fa fa-pencil-square-o"></i></span>
      <textarea class="form-control" type="text" placeholder="Optional" id="remarks"></textarea>
      </div>
      <br><br><br><br>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="confirm_close">Close</button>
      </div>
    </div>

  </div>
</div>

@endsection

@section('js-files')
    <!-- Custom File -->
        <script src="{{ asset('taxi/taxi_closing.js') }}" defer></script>
@endsection