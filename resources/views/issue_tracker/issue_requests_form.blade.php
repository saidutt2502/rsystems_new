@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Issue Tracker</li>
@endsection


@section('page-header')
    <h1>Issue Tracker
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Form</small>
    </h1>
@endsection

@section('main-content')

    <form class="form-horizontal" role="form" action="{{URL::to('forms_issues')}}" method="POST">
    @csrf

    
         <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Issue</label>
        <div class="col-sm-9">
        <textarea name="issue" class="col-xs-10 col-sm-5" type="text"  required></textarea>
        </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Remarks</label>
        <div class="col-sm-9">
        <textarea name="remark" class="col-xs-10 col-sm-5" placeholder="Optional" type="text"></textarea>
        </div>
        </div>

        <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" >Concerned Module</label>

                <div class="col-sm-4">
                    
                        <select  name="dept_id" class="chosen-container chosen-container-single chosen-select"  required>
                            <option value="" disabled selected>Select Module</option>
                            @foreach($departments as $department)
                                 <option value="{{$department->id}}">{{$department->module_name}}</option>
                            @endforeach   
                        </select>
                   
                 </div>
        </div>

        
        <div class="clearfix form-actions">
            <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-info" type="submit" id="submitt">
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
<!-- <input type="hidden" value="{{URL::to('taxi-ajax')}}" id="url_ajax"> -->
        

@endsection

@section('js-files')
    <!-- Custom File -->
    <script src="{{ asset('taxi/taxi_form.js') }}" defer></script>
@endsection