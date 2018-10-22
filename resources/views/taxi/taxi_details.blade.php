@extends('layouts.user-master')

@section('css-files')
<link rel="stylesheet" href="{{ asset('/taxi/taxidetails.css') }}" />
@endsection

@section('breadcrumb')
    <li class="active">Taxi Settings</li>
@endsection


@section('main-content')
    <b>ADD VENDOR</b><br>
    <div class="form-group">

            <div class="col-xs-12 col-sm-5 col-sm-offset-3">
                <span class="block input-icon input-icon-right">
                    <input id="vendor_name" placeholder="Vendor Name" class="width-100" type="text">
                    <i id="add_vendor" class="ace-icon fa fa-gavel"></i>
                </span>
            </div>
            <div class="help-block col-xs-12 col-sm-reset inline">&nbsp;</div>
    </div>
    <hr />
    <b>TAXI TYPE</b><br>
    <div class="form-group">
    <div class="col-sm-12 col-sm-offset-2">
        <div class="col-sm-4">

        <?php
               $vendors=DB::table('rs_taxi_vendors')->where('location_id',session('location'))->get();
        ?>

        <label>Vendor</label>
        <select id="vendor" class="chosen-container chosen-container-single chosen-select">
                               <option selected disabled>Select Vendor</option>
                               @foreach($vendors as $vendor)
                              <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                              @endforeach
        </select><br>
        </div>

        <div class="col-sm-4">
        <label>Taxi Type</label>
        <input type="text" autocomplete="off" id="type" class="form-control"><br>
        </div>
    </div>
    </div>
   

    <div class="form-group">
    <div class="col-sm-12 col-sm-offset-2">
        <div class="col-sm-4">

        <?php
               $base_kms=DB::table('rs_taxisettings')->where('location_id',session('location'))->first();
        ?>

        <label>Cost per {{$base_kms->base_kms}} Kms</label>
        <input type="text" autocomplete="off" id="base_kms" class="form-control"><br>
        </div>

        <div class="col-sm-4">
        <label>Cost per Km</label>
        <input type="text" autocomplete="off" id="per_km" class="form-control"><br>
        </div>
    </div>
    </div>

    <div class="form-group">
    <div class="col-sm-12 col-sm-offset-2">
        <div class="col-sm-3">

        <label>Night Charges</label>
        <input type="text" autocomplete="off" id="night" class="form-control"><br>
        </div>

        <div class="col-sm-3">
        <label>Midnight Charges</label>
        <input type="text" autocomplete="off" id="midnight" class="form-control"><br>
        </div>

        <div class="col-sm-2">
        <label>Waiting Charges</label>
        <input type="text" autocomplete="off" id="wait" class="form-control"><br>
        </div>
    </div>
    </div>

    

            <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-info" type="button" id="submit">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Submit
                </button>

                &nbsp; &nbsp; &nbsp;
                <button class="btn" type="button" id="reset">
                    <i class="ace-icon fa fa-undo bigger-110"></i>
                    Reset
                </button>   
            
        </div>
  
     




<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('taxi-ajax')}}" id="url_ajax">
@endsection

@section('js-files')
        <script src="{{ asset('taxi/taxidetails.js') }}" defer></script>

@endsection