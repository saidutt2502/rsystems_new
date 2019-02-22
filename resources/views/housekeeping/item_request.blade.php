@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Housekeeping</li>
@endsection


@section('page-header')
    <h1>Housekeeping
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Form</small>
    </h1>
@endsection

@section('main-content')

    <form class="form-horizontal" role="form" action="{{URL::to('forms_hk')}}" method="POST">
    @csrf
    <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Pickup Date </label>

            <div class="col-sm-9">
                <input name="pickup_date" class="col-xs-10 col-sm-5" type="date">
            </div>
        </div>
        <div class="form-group">
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
        <div class="clone-this"></div>

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
        *Please click SUBMIT only once and allow a few seconds for form submission. 
    </form>
        

@endsection

@section('js-files')
    <!-- Custom File -->
    <script src="{{ asset('housekeeping/item_request.js') }}" defer></script>
@endsection