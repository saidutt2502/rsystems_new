@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Gatepass</li>
@endsection


@section('page-header')
    <h1>Gatepass
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Form</small>
    </h1>
@endsection

@section('main-content')

    <form class="form-horizontal" role="form" >
   

    <!-- Hidden values       -->
    <input type="hidden" value="{{$user->id}}" id="user_id">

    <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Date</label>

                <div class="col-sm-9">
                    <input id="date" class="col-xs-10 col-sm-5" type="date" required>
                </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Shift</label>
        
            <div class="col-sm-4">
                <select id="shift" class="chosen-container chosen-container-single chosen-select">
                               <option selected disabled>Select Shift</option>
                               @foreach($shifts as $shift)
                              <option value="{{$shift->id}}">{{$shift->name}}</option>
                              @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Purpose</label>
        
            <div class="col-sm-4">
                <select id="purpose" class="chosen-container chosen-container-single chosen-select">
                               <option selected disabled>Select Purpose</option>
                               <option value="Personal Work" >Personal Work</option>
                               <option value="Official Work" >Official Work</option>
                               <option value="Early Out" >Early Out</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Reason</label>

                <div class="col-sm-9">
                    <input id="reason" class="col-xs-10 col-sm-5" type="text" required>
                </div>
        </div>

       <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Will You Be Returning Back To The Company?</label>

            <div class="col-sm-4">
                <select id="return" class="chosen-container chosen-container-single chosen-select">
                    <option disabled selected >Select Option</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div>
        <div id="add_time"></div>

        
       

        <div class="clearfix form-actions">
            <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-info" type="button" id="submit">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Submit
                </button>

                &nbsp; &nbsp; &nbsp;
                <button class="btn" type="reset" id="reset">
                    <i class="ace-icon fa fa-undo bigger-110"></i>
                    Reset
                </button>
            </div>
           
		</div>
        *Please click SUBMIT only once and allow a few seconds for form submission. 
    </form>

<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('gatepass_ajax')}}" id="url_ajax">

@endsection

@section('js-files')
    <!-- Custom File -->
    <script src="{{ asset('gatepass/gp_form.js') }}" defer></script>
@endsection