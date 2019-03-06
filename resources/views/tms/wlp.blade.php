@extends('layouts.user-master')


@section('css-files')
    <link rel="stylesheet" href="/core/css/bootstrap-duallistbox.min.css" />
@endsection



@section('breadcrumb')
    <li class="active">Tool Management</li>
@endsection


@section('page-header')
    <h1>Production
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Workstations,Lines &amp Products</small>
    </h1>
@endsection

@section('main-content')
<form class="form-horizontal" role="form" action="{{URL::to('add_wlp')}}" method="POST">
    @csrf


        <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Department </label>

               

                <div class="col-sm-4">
                    <select id="selected_dept" name="dept_selected_dd" class="chosen-container chosen-container-single chosen-select ">
                               <option selected disabled>Select Existing Department</option>
                               @foreach($dept as $each_dept)
                              <option value="{{$each_dept->id}}">{{$each_dept->name}}</option>
                              @endforeach
                    </select>
                </div>

              

                    
        </div>
        <br><br> 
        <div class="form-group" id="append_to_this_wk">
            <label class="col-sm-3 control-label no-padding-right">Workstations</label>

            <div class="col-sm-9">
                <!-- <input name="wk[]" class="col-xs-10 col-sm-5" type="text">&nbsp;&nbsp;&nbsp; -->
                <button class="btn btn-xs" type="button" id="add_wk">
                    <i class="ace-icon fa fa-plus bigger-110"></i>
                </button>
            </div>

           
        </div>
       
        <div class="hr hr-16 hr-dotted"></div>

        <div class="form-group" id="append_to_this_lines">
            <label class="col-sm-3 control-label no-padding-right">Lines</label>

            <div class="col-sm-9">
                <!-- <input name="lines[]" class="col-xs-10 col-sm-5" type="text">&nbsp;&nbsp;&nbsp; -->
                <button class="btn btn-xs" type="button" id="add_lines">
                    <i class="ace-icon fa fa-plus bigger-110"></i>
                </button>
            </div>

           
        </div>
       
        <div class="hr hr-16 hr-dotted"></div>

        <div class="form-group" id="append_to_this_products">
            <label class="col-sm-3 control-label no-padding-right">Products</label>

            <div class="col-sm-9">
                <!-- <input name="products[]" class="col-xs-10 col-sm-5" type="text">&nbsp;&nbsp;&nbsp; -->
                <button class="btn btn-xs" type="button" id="add_products">
                    <i class="ace-icon fa fa-plus bigger-110"></i>
                </button>
            </div>

           
        </div>
       
        <div class="hr hr-16 hr-dotted"></div>


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


        <!-- Hidden values       -->
<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('tms_ajax')}}" id="url_ajax">

@endsection

@section('js-files')
    <!-- Custom File -->
    <script src="{{ asset('tms/wlp.js') }}" defer></script>
    <script src="/core/js/jquery.bootstrap-duallistbox.min.js"></script>
@endsection