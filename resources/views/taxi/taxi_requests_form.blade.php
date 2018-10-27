@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Taxi</li>
@endsection


@section('page-header')
    <h1>Taxi
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Form</small>
    </h1>
@endsection

@section('main-content')

    <form class="form-horizontal" role="form" action="{{URL::to('forms_taxi')}}" method="POST">
    @csrf

        <input type="hidden" value="{{$user->id}}" name="user_id">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Date </label>

            <div class="col-sm-9">
                <input name="date" class="col-xs-10 col-sm-5" type="date" required autofocus>
            </div>
        </div>

         <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Location</label>
        <div class="col-sm-4">
                <select name="location" id="location" class="chosen-container chosen-container-single chosen-select" required>
                    <option disabled selected >Select Location</option>
                    @foreach($locations as $location)
                         <option value="{{$location->id}}">{{$location->name}}</option>
                    @endforeach
                </select>
        </div>
        </div>

        <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" >Cost Center</label>

                <div class="col-sm-4">
                    
                        <select  name="cc_id" class="chosen-container chosen-container-single chosen-select"  required>
                            <option value="" disabled selected>Select Cost Center</option>
                            @foreach($costcenters as $costcenter)
                                 <option value="{{$costcenter->id}}">{{$costcenter->number}}</option>
                            @endforeach   
                        </select>
                   
                 </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Trip Type </label>
        <div class="col-sm-4">
                <select name="trip_type" id="trip_type" class="chosen-container chosen-container-single chosen-select"  required>
                    <option disabled selected >Select Trip Type</option>
                    <option value="Local Run">Local Run</option>
                    <option value="Airport">Airport</option>
                </select>
        </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Purpose</label>

            <div class="col-sm-9">
                <textarea name="purpose" class="col-xs-10 col-sm-5" type="text"  required></textarea>
            </div>
        </div>
        <div id="add_form"></div>
        
        
        <!-- Hidden values       -->

        <div class="clearfix form-actions">
            <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-info" type="submit">
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
    </form>
        

@endsection

@section('js-files')
    <!-- Custom File -->
    <script src="{{ asset('taxi/taxi_form.js') }}" defer></script>
@endsection