@extends('layouts.user-master')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('admins-section/steps/step.css') }}" />
@endsection

@section('breadcrumb')
    <li class="active">Cost Centers</li>
@endsection


@section('page-header')
<ul class="nav nav-tabs">
  <li class="active"><a href="hod_cc">Cost Center Details</a></li>
  <li><a href="hod_cc_allocation">Cost Center Allocation</a></li>
  
</ul>
@endsection

@section('main-content')

 
  <br>

<table id="simple-table" class="table  table-bordered table-hover">
    <thead>
    <tr>
        <th class="detail-col">Details</th>
        <th>Name</th>
        <th>Location</th>
    </tr>
    </thead>
    <tbody>
    @if($departments)
        @foreach($departments as $department)
        <?php
        $costcenters = DB::table('rs_costcenters')->where('department',$department->id)->get();
        ?>   
        <tr>
            <td class="center">
                <div class="action-buttons">
                    <a href="#" class="green bigger-140 show-details-btn" title="Show Details">
                        <i class="ace-icon fa fa-angle-double-down"></i>
                        <span class="sr-only">Details</span>
                    </a>
                </div>
            </td>
            <td>
                <a href="#!">{{$department->name}}</a>
            </td>
            <td><a href="#!">{{$department->l_name}}</a></td>

        </tr>
        <tr class="detail-row">
            <td colspan="8">
                <div class="input-group col-sm-7  col-sm-offset-2 hidden-480">
                    <span class="input-group-addon"><i class="ace-icon fa fa-gavel"></i></span>
                    <input class="form-control cc_no" input-id="" placeholder="Cost Center Number (Name)" type="text">
                    <span class="input-group-btn">
                    <button type="button" class="btn btn-purple btn-sm add_cc" dept-id="{{$department->id}}">
                    <span class="ace-icon fa fa-check icon-on-right bigger-110"></span>
                    Add
                    </button>
                    </span>
                </div><br>
                     @if($costcenters)
                        @foreach($costcenters as $costcenter)
                                    <div class="col-xs-12 col-sm-7 col-sm-offset-2 ">
                                        <div class="col-xs-12 col-sm-12 col-md-12 widget-container-col ui-sortable" id="widget-container-col-3">
                                            <div class="widget-box collapsed ui-sortable-handle" id="widget-box-3">
                                                <div class="widget-header widget-header-small">
                                                    <h6 class="widget-title each_dept_name">{{$costcenter->number}}</h6>
                                                    <div class="widget-toolbar hidden-480">
                                                        <a href="#"><i cc-id="{{$costcenter->id}}" class="ace-icon fa fa-times red2 remove-cc"></i></a>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                     @endif
            </td>
        </tr>
        @endforeach
    @endif
    </tbody>
</table>

<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('step')}}" id="url_ajax">

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirm delete location?</h4>
      </div>
      <div class="modal-body">
        <p>Deleting this location will also delete all the departments assigned to this location.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="confirm_delete">Confirm</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

@endsection

@section('js-files')
    <!-- Custom File -->
        <script src="{{ asset('admins-section/steps/hod_cc.js') }}" defer></script>
@endsection