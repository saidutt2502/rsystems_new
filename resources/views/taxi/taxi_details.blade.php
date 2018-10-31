@extends('layouts.user-master')

@section('css-files')
<link rel="stylesheet" href="{{ asset('/taxi/taxidetails.css') }}" />
@endsection

@section('breadcrumb')
    <li class="active">Taxi Details</li>
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

                                            <!-- TAXI TYPE -->
    <b>TAXI TYPE</b><br>
    *All unrelated fields must have the value 0
    <br><br><br>
    <div class="form-group">
    <div class="col-sm-12 col-sm-offset-2">
        <div class="col-sm-4">


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
        <input type="text" autocomplete="off" id="base_kms" class="form-control" value="0"><br>
        </div>

        <div class="col-sm-4">
        <label>Cost per Km</label>
        <input type="text" autocomplete="off" id="per_km" class="form-control" value="0"><br>
        </div>
    </div>
    </div>

    <div class="form-group">
    <div class="col-sm-12 col-sm-offset-2">
        <div class="col-sm-3">

        <label>Night Charges</label>
        <input type="text" autocomplete="off" id="night" class="form-control" value="0"><br>
        </div>

        <div class="col-sm-3">
        <label>Midnight Charges</label>
        <input type="text" autocomplete="off" id="midnight" class="form-control" value="0"><br>
        </div>

        <div class="col-sm-2">
        <label>Waiting Charges</label>
        <input type="text" autocomplete="off" id="wait" class="form-control" value="0"><br>
        </div>
    </div>
    </div>

    @if($airports)
    @foreach(explode(',', $airports->airport_locations) as $each_location)
    @if($each_location != '')
    <div class="form-group">
    <div class="col-sm-12 col-sm-offset-2">
        <div class="col-sm-4">

        <label>Place</label>
        <input type="text" autocomplete="off" class="form-control" value="{{$each_location}}" disabled><br>
        </div>

        <div class="col-sm-4">
        <label>Airport Charges</label>
        <input type="text" autocomplete="off" data-place="{{$each_location}}" class="form-control  airport_details_input" value="0"><br>
        </div>
    </div>
    </div>
    @endif
    @endforeach
    @endif
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

                                              <!-- CARS -->
    <div class="row">   
    <div class="col-xs-12"><hr>
    <b>CARS</b><br>
    <div class="form-group">
    <div class="col-sm-12 col-sm-offset-2">
    <div class="col-sm-3">
 

        <label>Vendor</label>
        <select id="vendor_car" class="chosen-container chosen-container-single chosen-select">
                               <option selected disabled>Select Vendor</option>
                               @foreach($vendors as $vendor)
                              <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                              @endforeach
        </select><br>
        </div>

        <div class="col-sm-3">

        <label>Type</label>
        <select id="type_car" class="chosen-container chosen-container-single chosen-select">
                       <option selected disabled>Select Type</option>
        </select><br>
        </div>

        <div class="col-sm-2">
        <label>Taxi No.</label>
        <input type="text" autocomplete="off" id="taxino" class="form-control"><br>
        </div>

    </div>
    </div>

    <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-info" type="button" id="submit_car">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Submit
                </button>

                &nbsp; &nbsp; &nbsp;
                <button class="btn" type="button" id="reset_car">
                    <i class="ace-icon fa fa-undo bigger-110"></i>
                    Reset
                </button>   
            
        </div>


    <hr></div>
</div>

    

            
  
     




<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('taxi-ajax')}}" id="url_ajax">
@endsection

@section('js-files')
        <script src="{{ asset('taxi/taxidetails.js') }}" defer></script>

@endsection