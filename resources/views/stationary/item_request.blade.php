@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Stationary</li>
@endsection


@section('page-header')
    <h1>Stationary
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Form</small>
    </h1>
@endsection

@section('main-content')

    <form class="form-horizontal" role="form" action="{{URL::to('forms_stationary')}}" method="POST">
    @csrf
        <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" >Cost Center</label>

                <div class="col-sm-9">
                    <div class="col-sm-5">
                        <select  name="cc_id" class="chosen-container chosen-container-single chosen-select">
                            <option value="" disabled selected>Select Cost Center</option>
                                @foreach($cc as $each_cc)
                                <option value="{{$each_cc->id}}">{{$each_cc->number}}</option>
                                @endforeach
                        </select>
                    </div>
                 </div>
        </div>
        <div class="form-group clone-this">
            <label class="col-sm-3 control-label no-padding-right" >Request</label>

            <div class="col-sm-9">
                <div class="col-sm-5">
                    <select id="item_id" name="item_id[]" class="chosen-container chosen-container-single chosen-select">
                        <option value="" disabled selected>Select Item</option>
                            @foreach($items as $each_item)
                            <option class="item_options" value="{{$each_item->id}}">{{$each_item->name}}</option>
                            @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                <span class="input-icon">
                            <input id="update_qty" placeholder="Quantity" name="qty[]" type="text">
                            <i class="ace-icon fa fa-envelope blue"></i>
                    </span>
                </div>
                <div class="col-sm-1 col-md-1">
                    <button type="button" class="btn btn-warning btn-block btn-xs btn-clone">
                        <i class="ace-icon fa fa-plus bigger-110 icon-only"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Remarks </label>

                <div class="col-sm-9">
                    <input name="remarks" class="col-xs-10 col-sm-5" type="text">
                </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Pickup Date </label>

            <div class="col-sm-9">
                <input name="pickup_date" class="col-xs-10 col-sm-5" type="date">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Time Slot </label>

            <div class="col-sm-4">
                <select name="time_slot" class="chosen-container chosen-container-single chosen-select">
                    <option disabled selected >Select a Timeslot.</option>
                    <option value="10:00am-11:00am">10:00am-11:00am</option>
                    <option value="04:00pm-05:00pm">04:00pm-05:00pm</option>
                </select>
            </div>
        </div>
        <!-- Hidden values       -->
        <input type="hidden" value="{{$user->id}}" name="user_id">
        <input type="hidden" value="item_request" name="function_name">

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
    </form>
        

@endsection

@section('js-files')
    <!-- Custom File -->
    <script src="{{ asset('stationary/item_request.js') }}" defer></script>
@endsection