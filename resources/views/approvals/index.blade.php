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
                                    <div>
                                        <h4 class="media-heading">
											<a href="#" class="blue">{{$each_approval->module_name}}&nbsp;&nbsp;|&nbsp;&nbsp;{{$details->loc_name}}</a>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ date("D, d F Y",strtotime($each_approval->updated_at))}}</span>
										</h4>
                                    </div>
                                        @switch($each_approval->src_table)
                                            @case('rs_stationaryrequests')
                                                    <p>
                                                        User:&nbsp;<b>{{$details->name}}&nbsp;(Employee Code:&nbsp;{{$details->emp_id}})</b>&nbsp;&nbsp;|&nbsp;&nbsp;Requested:&nbsp;<b>{{$details->quantity}} {{$details->item_name}}</b>&nbsp;&nbsp;|&nbsp;&nbsp; Remarks:&nbsp;<b>{{$details->remarks}}</b><br>
                                                    Time slot:<b>{{$details->time_slot}}</b>&nbsp;&nbsp;|&nbsp;&nbsp;Pickup Date:&nbsp;<b>{{ date("D, d F Y",strtotime($details->p_date))}}</b>
                                                    </p>
                                                @break
                                        @endswitch
                                    <div class="search-actions text-center">
                                        <a class="btn btn-sm btn-block btn-info">Approve!</a>
                                        <a class="btn btn-sm btn-block btn-danger">Reject!</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        </div>
                    </div>
                </div>

<!-- Declined Approvals here -->
                <div id="messages" class="tab-pane fade">
                <div class="row">
                        <div class="col-xs-12">
                            @if($decline)
                                @foreach($decline as $each_decline)

 <?php
        $d_details = DB::table('rs_stationaryrequests')
        ->join('users', 'users.id', '=', 'rs_stationaryrequests.user_id')
        ->join('rs_items', 'rs_items.id', '=', 'rs_stationaryrequests.item_id')
        ->join('rs_locations', 'rs_locations.id', '=', 'rs_stationaryrequests.location_id')
        ->join('rs_costcenters', 'rs_costcenters.id', '=', 'rs_stationaryrequests.costcenter_id')
        ->select('users.name as name','users.emp_id as emp_id', 'rs_items.name as item_name', 'rs_locations.name as loc_name','rs_costcenters.number as cost_center','rs_stationaryrequests.quantity as quantity','rs_stationaryrequests.remarks as remarks',
        'rs_stationaryrequests.pickup_date as p_date',
        'rs_stationaryrequests.time_slot as time_slot')
        ->where('rs_stationaryrequests.id',$each_decline->src_id)
        ->first();
    ?>

                            <div class="media search-media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object" data-src="holder.js/72x72" alt="72x72" style="width: 72px; height: 72px;" src="/core/images/avatars/avatar2.png" data-holder-rendered="true">
                                    </a>
                                </div>

                                <div class="media-body">
                                    <div>
                                        <h4 class="media-heading">
											<a href="#" class="blue">{{$each_decline->module_name}}&nbsp;&nbsp;|&nbsp;&nbsp;{{$d_details->loc_name}}</a>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ date("D, d F Y",strtotime($each_decline->updated_at))}}</span>
										</h4>
                                    </div>
                                        @switch($each_decline->src_table)
                                            @case('rs_stationaryrequests')
                                                    <p>
                                                        User:&nbsp;<b>{{$details->name}}&nbsp;(Employee Code:&nbsp;{{$d_details->emp_id}})</b>&nbsp;&nbsp;|&nbsp;&nbsp;Requested:&nbsp;<b>{{$d_details->quantity}} {{$d_details->item_name}}</b>&nbsp;&nbsp;|&nbsp;&nbsp; Remarks:&nbsp;<b>{{$d_details->remarks}}</b><br>
                                                    Time slot:<b>{{$d_details->time_slot}}</b>&nbsp;&nbsp;|&nbsp;&nbsp;Pickup Date:&nbsp;<b>{{ date("D, d F Y",strtotime($d_details->p_date))}}</b>
                                                    </p>
                                                @break
                                        @endswitch
                                    <div class="search-actions text-center">
                                        <a class="btn btn-sm btn-block btn-info">Approve!</a>
                                        <a class="btn btn-sm btn-block btn-danger">Reject!</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        </div>
                </div>
            </div>

                <div id="approved" class="tab-pane fade">
                    <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col -->
</div>
    
<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('stationary_ajax')}}" id="url_ajax">

@endsection

@section('js-files')
    <!-- Custom File -->
    <script>
    $(document).ready(function () {
            $('#home_tab_first').addClass('active');
    });
    </script>

@endsection