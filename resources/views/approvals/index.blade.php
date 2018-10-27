@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Approvals</li>
@endsection


@section('page-header')
    <h1>Approve
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Requests</small>
    </h1>
@endsection

@section('main-content')
<div class="row">
    <div class="col-sm-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li id="home_tab_first" class="active">
                    <a data-toggle="tab" href="#home">
                        <i class="green ace-icon fa fa-home bigger-120"></i> Pending Approvals
                        <span class="badge badge-danger">{{$count}}</span>
                    </a>
                </li>

                <li>
                    <a data-toggle="tab" href="#messages">
                        Declined Requests
                    </a>
                </li>

                <li>
                    <a data-toggle="tab" href="#approved">
                        Approved Requests
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-xs-12">
                            @if($approve)
                                @foreach($approve as $each_approval)
                                    @if($each_approval->status==1)

 <?php
        $details = DB::table('rs_stationaryrequests')
        ->join('users', 'users.id', '=', 'rs_stationaryrequests.user_id')
        ->join('rs_items', 'rs_items.id', '=', 'rs_stationaryrequests.item_id')
        ->join('rs_locations', 'rs_locations.id', '=', 'rs_stationaryrequests.location_id')
        ->join('rs_costcenters', 'rs_costcenters.id', '=', 'rs_stationaryrequests.costcenter_id')
        ->select('users.name as name','users.emp_id as emp_id', 'rs_items.name as item_name', 'rs_locations.name as loc_name','rs_costcenters.number as cost_center','rs_stationaryrequests.quantity as quantity','rs_stationaryrequests.remarks as remarks',
        'rs_stationaryrequests.pickup_date as p_date',
        'rs_stationaryrequests.time_slot as time_slot')
        ->where('rs_stationaryrequests.id',$each_approval->src_id)
        ->first();
    ?>

                            <div class="media search-media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object" data-src="holder.js/72x72" alt="72x72" style="width: 72px; height: 72px;" src="/core/images/avatars/avatar2.png" data-holder-rendered="true">
                                    </a>
                                </div>

                                <div class="media-body">
                                        @switch($each_approval->src_table)
                                            @case('rs_stationaryrequests')
                                            <div>
                                                <h4 class="media-heading">
                                                    <a href="#" class="blue">{{$each_approval->module_name}}&nbsp;&nbsp;|&nbsp;&nbsp;{{$details->loc_name}}</a>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ date("D, d F Y",strtotime($each_approval->updated_at))}}</span>
                                                </h4>
                                            </div>
                                                    <p>
                                                    User:&nbsp;<b>{{$details->name}}&nbsp;(Employee Code:&nbsp;{{$details->emp_id}})</b>&nbsp;&nbsp;|&nbsp;&nbsp;Requested:&nbsp;<b>{{$details->quantity}} {{$details->item_name}}</b>&nbsp;&nbsp;|&nbsp;&nbsp; Remarks:&nbsp;<b>{{$details->remarks}}</b><br>
                                                    Time slot:<b>{{$details->time_slot}}</b>&nbsp;&nbsp;|&nbsp;&nbsp;Pickup Date:&nbsp;<b>{{ date("D, d F Y",strtotime($details->p_date))}}</b>
                                                    </p>
                                                @break
                                            @case('rs_gp_entries')
                                            <?php

                                             $details_gatepass = DB::table('rs_gp_entries')
                                             ->join('users', 'users.id', '=', 'rs_gp_entries.user_id')
                                             ->join('rs_locations', 'rs_locations.id', '=', 'rs_gp_entries.location_id')
                                             ->join('rs_gp_settings', 'rs_gp_settings.id', '=', 'rs_gp_entries.shift_id')
                                             ->select('users.name as name','users.emp_id as emp_id', 'rs_gp_entries.*','rs_locations.name as loc_name','rs_gp_settings.name as shift_name')
                                             ->where('rs_gp_entries.id',$each_approval->src_id)
                                             ->first();

                                            ?>
                                             <div>
                                                    <h4 class="media-heading">
                                                        <a href="#" class="blue">{{$each_approval->module_name}}&nbsp;&nbsp;|&nbsp;&nbsp;{{$details_gatepass->loc_name}}</a>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ date("D, d F Y",strtotime($each_approval->updated_at))}}</span>
                                                    </h4>
                                                </div>
                                                    <p>
                                                    User:&nbsp;<b>{{$details_gatepass->name}}&nbsp;(Employee Code:&nbsp;{{$details_gatepass->emp_id}})</b>&nbsp;&nbsp;|&nbsp;&nbsp;Shift:&nbsp;<b>{{$details_gatepass->shift_name}}</b>&nbsp;&nbsp;</b><br>
                                                    Time:<b>{{$details_gatepass->from}} - @if($details_gatepass->to){{$details_gatepass->to}} @else No Return @endif</b>&nbsp;&nbsp;|&nbsp;&nbsp;Purpose:&nbsp;<b>{{$details_gatepass->purpose}}</b><br>
                                                    Reason:<b>{{$details_gatepass->reason}}</b>
                                                    </p>
                                                @break
                                                @case('rs_taxi_requests')
                                            <?php

                                             $details_taxi = DB::table('rs_taxi_requests')
                                             ->join('users', 'users.id', '=', 'rs_taxi_requests.user_id')
                                             ->join('rs_costcenters', 'rs_costcenters.id', '=', 'rs_taxi_requests.cc_id')
                                             ->join('rs_locations', 'rs_locations.id', '=', 'rs_taxi_requests.location')
                                             ->select('users.name as name','users.emp_id as emp_id', 'rs_taxi_requests.*','rs_costcenters.number as cost_center','rs_locations.name as location')
                                             ->where('rs_taxi_requests.id',$each_approval->src_id)
                                             ->first();

                                            ?>
                                             <div>
                                                    <h4 class="media-heading">
                                                        <a href="#" class="blue">{{$each_approval->module_name}}&nbsp;&nbsp;|&nbsp;&nbsp;{{$details_taxi->location}}</a>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ date("D, d F Y",strtotime($each_approval->updated_at))}}</span>
                                                    </h4>
                                                </div>
                                                    <p>
                                                    User:&nbsp;<b>{{$details_taxi->name}}&nbsp;(Employee Code:&nbsp;{{$details_taxi->emp_id}})</b>&nbsp;&nbsp;|&nbsp;&nbsp;From:&nbsp;<b>{{$details_taxi->place_from}}</b>&nbsp;&nbsp;To:&nbsp;<b>{{$details_taxi->place_to}}</b>&nbsp;&nbsp;<br>
                                                    Departure from {{$details_taxi->place_from}}:&nbsp;<b>{{$details_taxi->time1}} </b><br>
                                                    Departure from {{$details_taxi->place_to}}:&nbsp;<b>@if($details_taxi->time2 != null){{$details_taxi->time1}}@else - @endif </b><br>
                                                    Cost Center:&nbsp;<b>{{$details_taxi->cost_center}}&nbsp;</b>&nbsp;&nbsp;|&nbsp;&nbsp;Purpose:&nbsp;<b>{{$details_taxi->purpose}}</b>
                                                    </p>
                                            @break
                                        @endswitch
                                    <div class="search-actions text-center">
                                        <a class="btn btn-sm btn-block btn-info approve-btn" data-uniqueID="{{$each_approval->id}}" module-uniqueID="{{$each_approval->module_name}}" >Approve!</a>
                                        <a class="btn btn-sm btn-block btn-danger reject-btn" data-uniqueID="{{$each_approval->id}}">Reject!</a>
                                    </div>
                                </div>
                            </div>
                                @endif
                            @endforeach
                        @endif
                        </div>
                    </div>
                </div>

<!-- Declined Approvals here -->
                <div id="messages" class="tab-pane fade">
                <div class="row">
                        <div class="col-xs-12">
                        @if($approve)
                                @foreach($approve as $each_approval)
                                    @if($each_approval->status==3)

 <?php
        $d_details = DB::table('rs_stationaryrequests')
        ->join('users', 'users.id', '=', 'rs_stationaryrequests.user_id')
        ->join('rs_items', 'rs_items.id', '=', 'rs_stationaryrequests.item_id')
        ->join('rs_locations', 'rs_locations.id', '=', 'rs_stationaryrequests.location_id')
        ->join('rs_costcenters', 'rs_costcenters.id', '=', 'rs_stationaryrequests.costcenter_id')
        ->select('users.name as name','users.emp_id as emp_id', 'rs_items.name as item_name', 'rs_locations.name as loc_name','rs_costcenters.number as cost_center','rs_stationaryrequests.quantity as quantity','rs_stationaryrequests.remarks as remarks',
        'rs_stationaryrequests.pickup_date as p_date',
        'rs_stationaryrequests.time_slot as time_slot')
        ->where('rs_stationaryrequests.id',$each_approval->src_id)
        ->first();
    ?>

                            <div class="media search-media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object" data-src="holder.js/72x72" alt="72x72" style="width: 72px; height: 72px;" src="/core/images/avatars/avatar2.png" data-holder-rendered="true">
                                    </a>
                                </div>

                                <div class="media-body">
                                    
                                        @switch($each_approval->src_table)
                                            @case('rs_stationaryrequests')
                                        <div>
                                        <h4 class="media-heading">
											<a href="#" class="blue">{{$each_approval->module_name}}&nbsp;&nbsp;|&nbsp;&nbsp;{{$d_details->loc_name}}</a>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ date("D, d F Y",strtotime($each_approval->updated_at))}}</span>
										</h4>
                                        </div>
                                                    <p>
                                                        User:&nbsp;<b>{{$details->name}}&nbsp;(Employee Code:&nbsp;{{$d_details->emp_id}})</b>&nbsp;&nbsp;|&nbsp;&nbsp;Requested:&nbsp;<b>{{$d_details->quantity}} {{$d_details->item_name}}</b>&nbsp;&nbsp;|&nbsp;&nbsp; Remarks:&nbsp;<b>{{$d_details->remarks}}</b><br>
                                                    Time slot:<b>{{$d_details->time_slot}}</b>&nbsp;&nbsp;|&nbsp;&nbsp;Pickup Date:&nbsp;<b>{{ date("D, d F Y",strtotime($d_details->p_date))}}</b>
                                                    </p>
                                                @break
                                                @case('rs_gp_entries')
                                            <?php

                                             $details_gatepass = DB::table('rs_gp_entries')
                                             ->join('users', 'users.id', '=', 'rs_gp_entries.user_id')
                                             ->join('rs_locations', 'rs_locations.id', '=', 'rs_gp_entries.location_id')
                                             ->join('rs_gp_settings', 'rs_gp_settings.id', '=', 'rs_gp_entries.shift_id')
                                             ->select('users.name as name','users.emp_id as emp_id', 'rs_gp_entries.*','rs_locations.name as loc_name','rs_gp_settings.name as shift_name')
                                             ->where('rs_gp_entries.id',$each_approval->src_id)
                                             ->first();

                                            ?>
                                             <div>
                                                    <h4 class="media-heading">
                                                        <a href="#" class="blue">{{$each_approval->module_name}}&nbsp;&nbsp;|&nbsp;&nbsp;{{$details_gatepass->loc_name}}</a>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ date("D, d F Y",strtotime($each_approval->updated_at))}}</span>
                                                    </h4>
                                                </div>
                                                    <p>
                                                    User:&nbsp;<b>{{$details_gatepass->name}}&nbsp;(Employee Code:&nbsp;{{$details_gatepass->emp_id}})</b>&nbsp;&nbsp;|&nbsp;&nbsp;Shift:&nbsp;<b>{{$details_gatepass->shift_name}}</b>&nbsp;&nbsp;</b><br>
                                                    Time:<b>{{$details_gatepass->from}} - @if($details_gatepass->to){{$details_gatepass->to}} @else No Return @endif</b>&nbsp;&nbsp;|&nbsp;&nbsp;Purpose:&nbsp;<b>{{$details_gatepass->purpose}}</b><br>
                                                    Reason:<b>{{$details_gatepass->reason}}</b>
                                                    </p>
                                            @break
                                            @case('rs_taxi_requests')
                                            <?php

                                             $details_taxi = DB::table('rs_taxi_requests')
                                             ->join('users', 'users.id', '=', 'rs_taxi_requests.user_id')
                                             ->join('rs_costcenters', 'rs_costcenters.id', '=', 'rs_taxi_requests.cc_id')
                                             ->join('rs_locations', 'rs_locations.id', '=', 'rs_taxi_requests.location')
                                             ->select('users.name as name','users.emp_id as emp_id', 'rs_taxi_requests.*','rs_costcenters.number as cost_center','rs_locations.name as location')
                                             ->where('rs_taxi_requests.id',$each_approval->src_id)
                                             ->first();

                                            ?>
                                             <div>
                                                    <h4 class="media-heading">
                                                        <a href="#" class="blue">{{$each_approval->module_name}}&nbsp;&nbsp;|&nbsp;&nbsp;{{$details_taxi->location}}</a>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ date("D, d F Y",strtotime($each_approval->updated_at))}}</span>
                                                    </h4>
                                                </div>
                                                    <p>
                                                    User:&nbsp;<b>{{$details_taxi->name}}&nbsp;(Employee Code:&nbsp;{{$details_taxi->emp_id}})</b>&nbsp;&nbsp;|&nbsp;&nbsp;From:&nbsp;<b>{{$details_taxi->place_from}}</b>&nbsp;&nbsp;To:&nbsp;<b>{{$details_taxi->place_to}}</b>&nbsp;&nbsp;<br>
                                                    Departure from {{$details_taxi->place_from}}:&nbsp;<b>{{$details_taxi->time1}} </b><br>
                                                    Departure from {{$details_taxi->place_to}}:&nbsp;<b>@if($details_taxi->time2 != null){{$details_taxi->time1}}@else - @endif </b><br>
                                                    Cost Center:&nbsp;<b>{{$details_taxi->cost_center}}&nbsp;</b>&nbsp;&nbsp;|&nbsp;&nbsp;Purpose:&nbsp;<b>{{$details_taxi->purpose}}</b>
                                                    </p>
                                            @break    
                                        @endswitch
                                    <div class="search-actions text-center">
                                        <a class="btn btn-sm btn-block btn-info">Approve!</a>
                                        <a class="btn btn-sm btn-block btn-danger">Delete!</a>
                                    </div>
                                </div>
                            </div>
                                @endif
                            @endforeach
                        @endif
                        </div>
                </div>
            </div>

<!-- Approved List here -->
                <div id="approved" class="tab-pane fade">
                <div class="row">
                        <div class="col-xs-12">
                        @if($approve)
                                @foreach($approve as $each_approval)
                                    @if($each_approval->status !=1 && $each_approval->status != 3)

 <?php
        $a_details = DB::table('rs_stationaryrequests')
        ->join('users', 'users.id', '=', 'rs_stationaryrequests.user_id')
        ->join('rs_items', 'rs_items.id', '=', 'rs_stationaryrequests.item_id')
        ->join('rs_locations', 'rs_locations.id', '=', 'rs_stationaryrequests.location_id')
        ->join('rs_costcenters', 'rs_costcenters.id', '=', 'rs_stationaryrequests.costcenter_id')
        ->select('users.name as name','users.emp_id as emp_id', 'rs_items.name as item_name', 'rs_locations.name as loc_name','rs_costcenters.number as cost_center','rs_stationaryrequests.quantity as quantity','rs_stationaryrequests.remarks as remarks',
        'rs_stationaryrequests.pickup_date as p_date',
        'rs_stationaryrequests.time_slot as time_slot')
        ->where('rs_stationaryrequests.id',$each_approval->src_id)
        ->first();
    ?>

                            <div class="media search-media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object" data-src="holder.js/72x72" alt="72x72" style="width: 72px; height: 72px;" src="/core/images/avatars/avatar2.png" data-holder-rendered="true">
                                    </a>
                                </div>

                                <div class="media-body">
                                   
                                        @switch($each_approval->src_table)
                                            @case('rs_stationaryrequests')
                                    <div>
                                        <h4 class="media-heading">
											<a href="#" class="blue">{{$each_approval->module_name}}&nbsp;&nbsp;|&nbsp;&nbsp;{{$a_details->loc_name}}</a>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ date("D, d F Y",strtotime($each_approval->updated_at))}}</span>
										</h4>
                                    </div>
                                                    <p>
                                                        User:&nbsp;<b>{{$a_details->name}}&nbsp;(Employee Code:&nbsp;{{$a_details->emp_id}})</b>&nbsp;&nbsp;|&nbsp;&nbsp;Requested:&nbsp;<b>{{$a_details->quantity}} {{$a_details->item_name}}</b>&nbsp;&nbsp;|&nbsp;&nbsp; Remarks:&nbsp;<b>{{$a_details->remarks}}</b><br>
                                                    Time slot:<b>{{$a_details->time_slot}}</b>&nbsp;&nbsp;|&nbsp;&nbsp;Pickup Date:&nbsp;<b>{{ date("D, d F Y",strtotime($a_details->p_date))}}</b>
                                                    </p>
                                                @break
                                            @case('rs_gp_entries')
                                            <?php

                                             $details_gatepass = DB::table('rs_gp_entries')
                                             ->join('users', 'users.id', '=', 'rs_gp_entries.user_id')
                                             ->join('rs_locations', 'rs_locations.id', '=', 'rs_gp_entries.location_id')
                                             ->join('rs_gp_settings', 'rs_gp_settings.id', '=', 'rs_gp_entries.shift_id')
                                             ->select('users.name as name','users.emp_id as emp_id', 'rs_gp_entries.*','rs_locations.name as loc_name','rs_gp_settings.name as shift_name')
                                             ->where('rs_gp_entries.id',$each_approval->src_id)
                                             ->first();

                                            ?>
                                             <div>
                                                    <h4 class="media-heading">
                                                        <a href="#" class="blue">{{$each_approval->module_name}}&nbsp;&nbsp;|&nbsp;&nbsp;{{$details_gatepass->loc_name}}</a>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ date("D, d F Y",strtotime($each_approval->updated_at))}}</span>
                                                    </h4>
                                                </div>
                                                    <p>
                                                    User:&nbsp;<b>{{$details_gatepass->name}}&nbsp;(Employee Code:&nbsp;{{$details_gatepass->emp_id}})</b>&nbsp;&nbsp;|&nbsp;&nbsp;Shift:&nbsp;<b>{{$details_gatepass->shift_name}}</b>&nbsp;&nbsp;</b><br>
                                                    Time:<b>{{$details_gatepass->from}} - @if($details_gatepass->to){{$details_gatepass->to}} @else No Return @endif</b>&nbsp;&nbsp;|&nbsp;&nbsp;Purpose:&nbsp;<b>{{$details_gatepass->purpose}}</b><br>
                                                    Reason:<b>{{$details_gatepass->reason}}</b>
                                                    </p>
                                            @break

                                              @case('rs_taxi_requests')
                                            <?php

                                             $details_taxi = DB::table('rs_taxi_requests')
                                             ->join('users', 'users.id', '=', 'rs_taxi_requests.user_id')
                                             ->join('rs_costcenters', 'rs_costcenters.id', '=', 'rs_taxi_requests.cc_id')
                                             ->join('rs_locations', 'rs_locations.id', '=', 'rs_taxi_requests.location')
                                             ->select('users.name as name','users.emp_id as emp_id', 'rs_taxi_requests.*','rs_costcenters.number as cost_center','rs_locations.name as location')
                                             ->where('rs_taxi_requests.id',$each_approval->src_id)
                                             ->first();

                                            ?>
                                             <div>
                                                    <h4 class="media-heading">
                                                        <a href="#" class="blue">{{$each_approval->module_name}}&nbsp;&nbsp;|&nbsp;&nbsp;{{$details_taxi->location}}</a>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ date("D, d F Y",strtotime($each_approval->updated_at))}}</span>
                                                    </h4>
                                                </div>
                                                    <p>
                                                    User:&nbsp;<b>{{$details_taxi->name}}&nbsp;(Employee Code:&nbsp;{{$details_taxi->emp_id}})</b>&nbsp;&nbsp;|&nbsp;&nbsp;From:&nbsp;<b>{{$details_taxi->place_from}}</b>&nbsp;&nbsp;To:&nbsp;<b>{{$details_taxi->place_to}}</b>&nbsp;&nbsp;<br>
                                                    Departure from {{$details_taxi->place_from}}:&nbsp;<b>{{$details_taxi->time1}} </b><br>
                                                    Departure from {{$details_taxi->place_to}}:&nbsp;<b>@if($details_taxi->time2 != null){{$details_taxi->time1}}@else - @endif </b><br>
                                                    Cost Center:&nbsp;<b>{{$details_taxi->cost_center}}&nbsp;</b>&nbsp;&nbsp;|&nbsp;&nbsp;Purpose:&nbsp;<b>{{$details_taxi->purpose}}</b>
                                                    </p>
                                            @break
                                        @endswitch
                                </div>
                            </div>
                                @endif
                            @endforeach
                        @endif
                        </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col -->
</div>
    
<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('approval_ajax')}}" id="url_ajax">

@endsection

@section('js-files')
        <script src="{{ asset('approvalsFiles/approval.js') }}" defer></script>
@endsection