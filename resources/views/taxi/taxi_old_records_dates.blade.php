@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Taxi</li>
@endsection


@section('page-header')
    <h1>Taxi
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Old Records</small>
    </h1>
@endsection

@section('main-content')

    <form class="form-horizontal" role="form" action="{{URL::to('taxi_old_records_view')}}" method="POST">
    @csrf

       

          <div class="form-group">
             <label class="col-sm-3 control-label no-padding-right">Car No.</label> 
        <div class="col-sm-4">
                <select name="taxino" class="chosen-container chosen-container-single chosen-select" required>
                    <option disabled selected >Select Car No.</option>
                    @foreach($taxinos as $taxino)
                         <option value="{{$taxino->taxino}}">{{$taxino->taxino}}</option>
                    @endforeach
                </select>
        </div>
        </div> 

        <!-- <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Vendor Name</label>
        <div class="col-sm-4">
                <select name="vendor_name" class="chosen-container chosen-container-single chosen-select" required>
                    <option disabled selected >Select Vendor Name</option>
                    @foreach($taxinos as $taxino)
                         <option value="{{$taxino->taxino}}">{{$taxino->taxino}}</option>
                    @endforeach
                </select>
        </div>
        </div> -->

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">From</label>

            <div class="col-sm-9">
                <input name="from" class="col-xs-10 col-sm-5" type="date"  required/>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">To</label>

            <div class="col-sm-9">
                <input name="to" class="col-xs-10 col-sm-5" type="date"  required/>
            </div>
        </div>
         

        <div class="clearfix form-actions">
            <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-info" type="submit">
                    <i class="ace-icon fa fa-search bigger-110"></i>
                    Search
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

