@extends('layouts.user-master')


@section('css-files')
    <link rel="stylesheet" href="/core/css/bootstrap-duallistbox.min.css" />
@endsection



@section('breadcrumb')
    <li class="active">Tool Management</li>
@endsection


@section('page-header')
    <h1>Tool Management
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Supervisors</small>
    </h1>
@endsection

@section('main-content')
<form class="form-horizontal" role="form" action="{{URL::to('add_sup')}}" method="POST">
    @csrf


        <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Department </label>

                <div class="col-sm-4">
                    <select id="selected_dept" name="dept_selected_dd" class="chosen-container chosen-container-single chosen-select ">
                               <option disabled selected>Select Existing Department</option>
                               @foreach($dept as $each_dept)
                              <option value="{{$each_dept->id}}">{{$each_dept->name}}</option>
                              @endforeach
                    </select>
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
        
    </form>


        <!-- Hidden values       -->
<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('tms_ajax')}}" id="url_ajax">

@endsection

@section('js-files')
    <!-- Custom File -->
    <script src="{{ asset('tms/sup.js') }}" defer></script>
    <script src="/core/js/jquery.bootstrap-duallistbox.min.js"></script>
@endsection