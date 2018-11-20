@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Production</li>
@endsection


@section('page-header')
    <h1>Production
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Settings</small>
    </h1>
@endsection

@section('main-content')
<form class="form-horizontal" role="form" action="{{URL::to('forms_stationary')}}" method="POST">
    @csrf


        <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Department </label>

                <div class="col-sm-9">
                    <input name="department" class="col-xs-10 col-sm-5" type="text">
                </div>
        </div>
        <div class="form-group" id="append_to_this">
            <label class="col-sm-3 control-label no-padding-right">Company/Vendor </label>

            <div class="col-sm-9">
                <input name="vendor" class="col-xs-10 col-sm-5" type="text">&nbsp;&nbsp;&nbsp;
                <button class="btn btn-xs" type="button" id="add_vendor">
                    <i class="ace-icon fa fa-plus bigger-110"></i>
                </button>
            </div>

           
        </div>


        <!-- Hidden values       -->


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
    <script src="{{ asset('productions_js/productions.js') }}" defer></script>
@endsection