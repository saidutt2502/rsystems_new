@extends('layouts.user-master')


@section('css-files')
    <link rel="stylesheet" href="/core/css/bootstrap-duallistbox.min.css" />
@endsection



@section('breadcrumb')
    <li class="active">Production</li>
@endsection


@section('page-header')
    <h1>Production
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Settings</small>
    </h1>
@endsection

@section('main-content')
<form class="form-horizontal" role="form" action="{{URL::to('production_settings')}}" method="POST">
    @csrf


        <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Department </label>

                <div class="col-sm-9">
                    <input name="department" id="dept_name_clear" class="col-xs-10 col-sm-5" type="text">

                <div class="col-sm-4">
                    <select id="selected_dept" name="dept_selected_dd" class="chosen-container chosen-container-single chosen-select ">
                               <option value="0">Select Pre-filled Department</option>
                               @foreach($dept as $each_dept)
                              <option value="{{$each_dept->id}}">{{$each_dept->department}}</option>
                              @endforeach
                    </select>
                </div>

                </div>

            
        </div>
        <div class="form-group" id="append_to_this">
            <label class="col-sm-3 control-label no-padding-right">Company/Vendor </label>

            <div class="col-sm-9">
                <input name="company[]" class="col-xs-10 col-sm-5" type="text">&nbsp;&nbsp;&nbsp;
                <button class="btn btn-xs" type="button" id="add_vendor">
                    <i class="ace-icon fa fa-plus bigger-110"></i>
                </button>
            </div>

           
        </div>
       
        <div class="hr hr-16 hr-dotted"></div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-top" for="duallist"> Users List </label>

                <div class="col-sm-8" >
                    <div id="insert_here_dd">
                    <select multiple="multiple" size="10" name="user_list[]" id="duallist">
                      
                    </select>
                    </div>
                    <div class="hr hr-16 hr-dotted"></div>
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
        *Please click SUBMIT only once and allow a few seconds for form submission. 
    </form>


        <!-- Hidden values       -->
<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('production_ajax')}}" id="url_ajax">

@endsection

@section('js-files')
    <!-- Custom File -->
    <script src="{{ asset('productions_js/productions.js') }}" defer></script>
    <script src="/core/js/jquery.bootstrap-duallistbox.min.js"></script>
@endsection