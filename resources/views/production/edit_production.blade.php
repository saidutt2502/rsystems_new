@extends('layouts.user-master')


@section('css-files')
    <link rel="stylesheet" href="/core/css/bootstrap-duallistbox.min.css" />
@endsection



@section('breadcrumb')
    <li class="active">Production</li>
@endsection


@section('page-header')
    <h1>Production
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Planners</small>
    </h1>
@endsection

@section('main-content')
<form class="form-horizontal" role="form" action="{{URL::to('edit_production_form')}}" method="POST">
    @csrf

            <div class="form-group">
                <div class="col-sm-12" >
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
<input type="hidden" value="{{URL::to('production_ajax')}}" id="url_ajax">

@endsection

@section('js-files')
    <!-- Custom File -->
    <script src="{{ asset('productions_js/productions_edit_list.js') }}" defer></script>
    <script src="/core/js/jquery.bootstrap-duallistbox.min.js"></script>
@endsection