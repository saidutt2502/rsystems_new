@extends('layouts.admin-master')

@section('breadcrumb')
    <li class="active">Holiday Calender</li>
@endsection


@section('page-header')
    <h1>{{ $name }}
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp; Holiday Calender</small>
    </h1>
@endsection

@section('main-content')


@if($exist)

<form class="form-horizontal" role="form" action="{{URL::to('holiday_calender_save')}}" method="POST">
    @csrf
   <div class="form-group clone-this">
   @foreach($exist as $each_exist)
   <div class="col-sm-3">
   </div>
   <div class="col-sm-3">
   <br>
                <span class="input-icon">
                            <input value="{{$each_exist->holiday_name}}" id="update_qty" placeholder="Holiday Name" name="holiday_name[]" type="text" autofocus required>
                            <i class="ace-icon glyphicon glyphicon-th-list blue"></i>
                    </span>
                </div>
                <div class="col-sm-3">
                <br>
                <span class="input-icon">
                            <input value="{{$each_exist->holiday_date}}" id="update_qty" placeholder="Quantity" name="holiday_date[]" type="date" required>
                            <i class="ace-icon fa fa-calendar blue"></i>
                    </span>
                </div>
                <!-- <div class="col-sm-1 col-md-1">
                <br>
                    <button type="button" class="btn btn-warning btn-block btn-xs btn-clone">
                        <i class="ace-icon fa fa-plus bigger-110 icon-only"></i>
                    </button>
                </div> -->
        </div>
        @endforeach

        <div class="clearfix form-actions">
            <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-info" type="submit">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Submit
                </button>

                &nbsp; &nbsp; &nbsp;
                <button class="btn" type="reset">
                    <i class="ace-icon fa fa-undo bigger-110"></i>
                    Reset
                </button>
            </div>
		</div>

         <!-- Location Id -->
         <input type="hidden" value="{{ $id }}" name="location_id">
                </form>

@else

<form class="form-horizontal" role="form" action="{{URL::to('holiday_calender_save')}}" method="POST">
    @csrf
   <div class="form-group clone-this">
   <div class="col-sm-3">
   </div>
   
   <div class="col-sm-3">
   <br>
                <span class="input-icon">
                            <input id="update_qty" placeholder="Holiday Name" name="holiday_name[]" type="text" autofocus required>
                            <i class="ace-icon glyphicon glyphicon-th-list blue"></i>
                    </span>
                </div>
                <div class="col-sm-3">
                <br>
                <span class="input-icon">
                            <input id="update_qty" placeholder="Quantity" name="holiday_date[]" type="date" required>
                            <i class="ace-icon fa fa-calendar blue"></i>
                    </span>
                </div>
                <div class="col-sm-1 col-md-1">
                <br>
                    <button type="button" class="btn btn-warning btn-block btn-xs btn-clone">
                        <i class="ace-icon fa fa-plus bigger-110 icon-only"></i>
                    </button>
                </div>
        </div>

        <div class="clearfix form-actions">
            <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-info" type="submit">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Submit
                </button>

                &nbsp; &nbsp; &nbsp;
                <button class="btn" type="reset">
                    <i class="ace-icon fa fa-undo bigger-110"></i>
                    Reset
                </button>
            </div>
		</div>

         <!-- Location Id -->
         <input type="hidden" value="{{ $id }}" name="location_id">
                </form>

@endif
   

   



       

    <!-- Ajax call url       -->
    <input type="hidden" value="{{URL::to('step')}}" id="url_ajax">

@endsection

@section('js-files')
    <!-- Custom File -->
    <script src="{{ asset('admins-section/steps/calender.js') }}" defer></script>
@endsection
