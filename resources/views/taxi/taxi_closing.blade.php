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
            <td><div class="search-actions text-center"><a class="btn btn-sm btn-block btn-danger assign-btn" >Delete!</a> </div></td>

        </tr>
        <tr class="detail-row">
            <td colspan="8">
                <input type="hidden" id="scheduled_trip" value="{{$schedule->id}}">
                <div class="input-group col-sm-7  col-sm-offset-5 hidden-480">
                <button type="button" id="add_trip" class="btn btn-purple btn-xs add_cc">
                    <span class="ace-icon fa fa-check icon-on-right bigger-110"></span>
                    Add&nbsp;&nbsp;
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
                                                    <h6 class="widget-title each_dept_name">{{$passengerdetail->name}} (Emp Id:{{$passengerdetail->emp_id}})&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$passengerdetail->place_from}} To {{$passengerdetail->place_to}}</h6>
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
<input type="hidden" value="{{URL::to('step')}}" id="url_ajax">

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirm delete location?</h4>
      </div>
      <div class="modal-body">
        <p>Deleting this location will also delete all the departments assigned to this location.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="confirm_delete">Confirm</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

@endsection

@section('js-files')
    <!-- Custom File -->
        <script src="{{ asset('admins-section/steps/hod_cc.js') }}" defer></script>
@endsection