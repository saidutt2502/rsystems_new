@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Issue Tracker</li>
@endsection


@section('page-header')
    <h1>Issue Tracker
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Issues Reported</small>
    </h1>
    
@endsection

@section('main-content')

<br><br>
    <div class="clearfix">
        <div class="pull-right tableTools-container"></div>
    </div>
    <div>
        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Department</th>
                    <th>Issue</th>
                    <th>Remarks</th>
                    <th>Reported By</th>
                    <th>Target Date</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($issues)
                    @foreach($issues as $each_request)
                    <?php
                    $dept_name= DB::table('rs_modules_programmer')->where('id',$each_request->department)->value('module_name');
                    $status= DB::table('rs_status')->where('id',$each_request->status)->value('html_string');
                    $username= DB::table('users')->where('id',$each_request->reporter_id)->value('name');
                    ?>
                        <tr>
                            <td>{{ date("D, d F Y",strtotime($each_request->reported_on))}}</td>
                            <td>{{$dept_name}}</td>
                            <td>{{$each_request->issue}}</td>
                            <td>@if($each_request->remark){{$each_request->remark}}@else - @endif</td>
                            <td>{{$username}}</td>
                            <td>@if($each_request->target_date){{date("D, d F Y",strtotime($each_request->target_date))}}@else Not Fixed @endif</td>
                            <td>{!!html_entity_decode($status)!!}</td>
                            <th></th>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>


        

@endsection

@section('js-files')
    <!-- Custom File -->
    <script src="{{ asset('admins-section/steps/initialize_datatables.js') }}" defer></script>
    <!-- <script src="{{ asset('stationary/stationary.js') }}" defer></script> -->

    <script src="/core/js/jquery-ui.min.js"></script>
    <script src="/core/js/jquery.ui.touch-punch.min.js"></script>

    <script src="/core/js/jquery.dataTables.min.js"></script>
    <script src="/core/js/jquery.dataTables.bootstrap.min.js"></script>
    <script src="/core/js/dataTables.buttons.min.js"></script>
    <script src="/core/js/buttons.flash.min.js"></script>
    <script src="/core/js/buttons.html5.min.js"></script>
    <script src="/core/js/buttons.print.min.js"></script>
    <script src="/core/js/buttons.colVis.min.js"></script>
    <script src="/core/js/dataTables.select.min.js"></script>
@endsection