@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Taxi</li>
@endsection

@section('css-files')
<link rel="stylesheet" href="/core/css/ace-skins.min.css" />
        <link rel="stylesheet" href="/core/css/daterangepicker.min.css" />
        <link rel="stylesheet" href="/core/css/bootstrap-datepicker3.min.css" />
		<link rel="stylesheet" href="/core/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" href="/core/css/daterangepicker.min.css" />
@endsection

@section('page-header')
    <h1>Taxi
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Reports</small>
    </h1>
@endsection

@section('main-content')

    <div class="col-xs-12 col-sm-12">
        <form class="form-horizontal" role="form"  method="POST" action="{{URL::to('report_taxi')}}" >
        @csrf
            <div class="form-group">
                <label class="col-md-offset-1 col-sm-3 control-label no-padding-right" for="form-field-1"> Report Type </label>

                <div class="col-sm-8">
                    <select name="report_type" class="col-xs-10 col-sm-5" class="form-control" id="r_type" required>
                            <option value="0" selected >Select Type</option>
                            <option value="1">Vendor</option>
                            <option value="2">Car</option>
                            <option value="3">Cost Center</option>
                    </select>
                </div>

            </div><br><br>

            <div class="form-group">
                <div class="col-md-offset-1 col-xs-9 col-sm-9">
                    <div class="input-group">
                        <input type="date" placeholder="Start Date" class="input-sm form-control" name="start_date" autocomplete="off" required>
                        <span class="input-group-addon">
                            <i class="fa fa-exchange"></i>
                        </span>
                        <input type="date" placeholder="End Date" class="input-sm form-control" name="end_date" autocomplete="off" required>
                    </div>
                </div>										
            </div>
            <br>
                    <hr>
            <br>

            <div class="form-group hide_default type_vendor  " style="display:none">
                <label class="col-sm-3 control-label no-padding-right col-md-offset-1" for="form-field-1"> Select vendor</label>
                <div class="col-sm-8">
                    <select required name="vendor_id" class="col-xs-10 col-sm-5" class="form-control" id="form-field-select-1">
                            <option value="0" selected disabled>Select Vendor</option>
                            @foreach($vendors as $each_vendor)
                                <option value="{{$each_vendor->id}}">{{$each_vendor->name}}</option>
                            @endforeach
                    </select>
                </div>								
            </div>

            <div class="form-group hide_default type_costcenter col-md-offset-1" style="display:none">
                <label class="col-sm-3 control-label no-padding-right col-md-offset-1" for="form-field-1"> Select Cost Center</label>
                <div class="col-sm-8">
                    <select required name="cc_id" class="col-xs-10 col-sm-5" class="form-control" id="form-field-select-1">
                            <option value="0" selected disabled>Select Cost Center</option>
                            @foreach($cc as $each_cc)
                                <option value="{{$each_cc->id}}">{{$each_cc->l_name}} - {{$each_cc->number}}</option>
                            @endforeach
                    </select>
                </div>								
            </div>

            <div class="form-group hide_default type_car col-md-offset-1" style="display:none">
                <label class="col-sm-3 control-label no-padding-right col-md-offset-1" for="form-field-1"> Select Car</label>
                <div class="col-sm-8">
                    <select required name="taxi_id" class="col-xs-10 col-sm-5" class="form-control" id="form-field-select-1">
                            <option value="0" selected disabled>Select Car</option>
                            @foreach($carnumber as $each_taxi)
                                <option value="{{$each_taxi->id}}">{{$each_taxi->taxino}}</option>
                            @endforeach
                    </select>
                </div>								
            </div>

            <div class="clearfix form-actions">
            <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-info" type="submit">
                    <i class="ace-icon fa fa-search bigger-110"></i>
                    Generate
                </button>

                &nbsp; &nbsp; &nbsp;
                <button class="btn" type="reset" id="reset">
                    <i class="ace-icon fa fa-undo bigger-110"></i>
                    Reset
                </button>
            </div>
		</div>

        </form>
    </div>
@endsection

@section('js-files')
    <!-- ace scripts -->
    <script src="/core/js/moment.min.js"></script>
    <script src="/core/js/daterangepicker.min.js"></script>
    <script src="/core/js/bootstrap-datepicker.min.js"></script>
    <script src="/core/js/bootstrap-timepicker.min.js"></script>
    <script src="/core/js/daterangepicker.min.js"></script>
    <script src="/core/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Custom File -->
        <script src="{{ asset('taxi/taxi_reports.js') }}" defer></script>

    
@endsection