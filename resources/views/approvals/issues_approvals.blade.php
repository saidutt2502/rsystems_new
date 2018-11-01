@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Issues</li>
@endsection


@section('page-header')
    <h1>Issue
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
                        <i class="green ace-icon fa fa-home bigger-120"></i> Pending Issues
                        <span class="badge badge-danger"></span>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-xs-12">
                            @if($issues)
                                @foreach($issues as $each_issues)
                            <div class="media search-media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object" data-src="holder.js/72x72" alt="72x72" style="width: 72px; height: 72px;" src="/core/images/avatars/avatar2.png" data-holder-rendered="true">
                                    </a>
                                </div>

                               <div class="media-body">
                                    <div>
                                        <h4 class="media-heading">
											<a href="#" class="blue">Stationary&nbsp;&nbsp;|&nbsp;&nbsp;{{$each_issues->loc_name}}</a>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ date("D, d F Y",strtotime($each_issues->updt_date))}}</span>
										</h4>
                                    </div>
                                        <p>
                                            User:&nbsp;<b>{{$each_issues->name}}&nbsp;(Employee Code:&nbsp;{{$each_issues->emp_id}})</b>&nbsp;&nbsp;|&nbsp;&nbsp;Requested:&nbsp;<b>{{$each_issues->quantity}} {{$each_issues->item_name}}</b>&nbsp;&nbsp;|&nbsp;&nbsp; Remarks:&nbsp;<b>{{$each_issues->remarks}}</b><br>
                                        Time slot:<b>{{$each_issues->time_slot}}</b>&nbsp;&nbsp;|&nbsp;&nbsp;Pickup Date:&nbsp;<b>{{ date("D, d F Y",strtotime($each_issues->p_date))}}</b>
                                        </p>
                                    <div class="search-actions text-center">
                                    <br>
                                        <a data-uniqueID="{{$each_issues->main_id}}" data-item_id="{{$each_issues->item_id}}" data-item_qty="{{$each_issues->quantity}}" class="btn btn-sm btn-block btn-info issue-btn">Issue!</a>
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
    </div>
    <!-- /.col -->
</div>
    
<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('approval_ajax')}}" id="url_ajax">

@endsection

@section('js-files')
        <script src="{{ asset('approvalsFiles/issue.js') }}" defer></script>
@endsection