@extends('layouts.admin-master')

@section('breadcrumb')
    <li class="active">Step-2</li>
@endsection


@section('page-header')
    <h1>{{ $name }}
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp; Holiday Calender</small>
    </h1>
@endsection

@section('main-content')
   

   <form class="form-horizontal">
                    <div class="form-group">
                        <label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right">Base Kilometers</label>
                        @if($taxisettings)
                        <div class="col-xs-12 col-sm-5">
                            <span class="block input-icon input-icon-right">
                                <input type="text" value="{{$taxisettings->base_kms}}" id="basekms" class="width-100" />
                            </span>
                        </div>
                        @else
                        <div class="col-xs-12 col-sm-5">
                            <span class="block input-icon input-icon-right">
                                <input type="text" id="basekms" class="width-100" />
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="inputError" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right">Day Charges Start at</label>
                        @if($taxisettings)
                        <div class="col-xs-12 col-sm-5">
                            <span class="block input-icon input-icon-right">
                                <input type="time"  value="{{$taxisettings->day_time}}" id="dayTime" class="width-100" />
                            </span>
                        </div>
                        @else
                        <div class="col-xs-12 col-sm-5">
                            <span class="block input-icon input-icon-right">
                                <input type="time" id="dayTime" class="width-100" />
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="inputError" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right">Night Charges Start at</label>
                        @if($taxisettings)
                        <div class="col-xs-12 col-sm-5">
                            <span class="block input-icon input-icon-right">
                                <input type="time"  value="{{$taxisettings->night_time}}" id="nightTime" class="width-100" />
                            </span>
                        </div>
                        @else
                        <div class="col-xs-12 col-sm-5">
                            <span class="block input-icon input-icon-right">
                                <input type="time" id="nightTime" class="width-100" />
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="inputSuccess" class="col-xs-12 col-sm-3 control-label no-padding-right">Mid-Night Charges starts at</label>
                        @if($taxisettings)
                        <div class="col-xs-12 col-sm-5">
                            <span class="block input-icon input-icon-right">
                                <input type="time" value="{{$taxisettings->midnight_time}}" id="midnightTime" class="width-100" />
                            </span>
                        </div>
                        @else
                        <div class="col-xs-12 col-sm-5">
                            <span class="block input-icon input-icon-right">
                                <input type="time"  id="midnightTime" class="width-100" />
                            </span>
                        </div>
                        @endif
                    </div>
                </form>



        <!-- Location Id -->
        <input type="hidden" value="{{ $id }}" id="location_id">

    <!-- Ajax call url       -->
    <input type="hidden" value="{{URL::to('step')}}" id="url_ajax">

@endsection

@section('js-files')
    <!-- Custom File -->
    <script src="{{ asset('admins-section/steps/initialize_datatables.js') }}" defer></script>
    <script src="{{ asset('admins-section/steps/loc_user.js') }}" defer></script>

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
