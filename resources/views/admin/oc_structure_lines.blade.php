@extends('layouts.admin-master')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('admins-section/steps/step.css') }}" />
@endsection

@section('breadcrumb')
    <li class="active">Organisation Chart</li>
@endsection


@section('page-header')
<ul class="nav nav-tabs">
  <li><a href="oc">OC Details</a></li>
  <li class="active"><a href="oc_structure">OC Structure</a></li>
  
</ul>
@endsection

@section('main-content')

 
  <br>
  <span class="label label-inverse">{{$deptname}} ({{$location->name}})</span>
  <span class="label label-inverse">Line {{$level}}</span>

  <br><br>

<table id="simple-table" class="table  table-bordered table-hover">
    <thead>
    <tr>
        <th class="detail-col">Assign</th>
        <th>Employee Id</th>
        <th>Employee Name</th>
    </tr>
    </thead>
    <tbody>
    @if($previouslines)
        @foreach($previouslines as $previousline)  
        <tr>
            <td class="center">
                <div class="action-buttons">
                    <a href="#" class="green bigger-140 show-details-btn" title="Show Details">
                        <i class="ace-icon fa fa-angle-double-down"></i>
                        <span class="sr-only">Assign</span>
                    </a>
                </div>
            </td>
            <td>
                <a href="#!">{{$previousline->emp_id}}</a>
            </td>
            <td><a href="#!">{{$previousline->name}}</a></td>

        </tr>
        <tr class="detail-row">
            <td colspan="8">
            <input type="hidden" id="dept" value="{{$departments}}">
            <input type="hidden" id="levels" value="{{$level}}">

  <div class="widget-box hidden-480">
            <div class="widget-header">
                <h4 class="widget-title"></h4>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-inline">
                    <select class="chosen-select form-control user_id">
                        <option value="" disabled selected>Select User</option>
                             @if($users)
                                @foreach($users as $user)
                                            
                                     <option value="{{$user->id}}">{{$user->name}} (Emp Id: {{$user->emp_id}})</option>
                                @endforeach
                             @endif         
                    </select><br><br>
                      
                        <center>
                        <button type="button" class="btn btn-info btn-sm add_emp1" reporter-id="{{$previousline->id}}">
                            <i class="ace-icon fa fa-check bigger-110"></i>Add
                        </button>
                        </center>
                    </form>
                </div>
            </div>
    </div>
            <br>

            <div id="{{$previousline->id}}_add"></div>

         @if($hierarchies)
                        @foreach($hierarchies as $hierarchy)
                                    <div class="col-xs-12 col-sm-7 col-sm-offset-2 " id="remove_{{$hierarchy->id}}">
                                        <div class="col-xs-12 col-sm-12 col-md-12 widget-container-col ui-sortable" id="widget-container-col-3">
                                            <div class="widget-box collapsed ui-sortable-handle" id="widget-box-3">
                                                <div class="widget-header widget-header-small">
                                                    <h6 class="widget-title each_dept_name">{{$hierarchy->name}} (Emp Id: {{$hierarchy->emp_id}})</h6>
                                                    <div class="widget-toolbar hidden-480">
                                                        <a href="#"><i class="ace-icon fa fa-times red2 del_emp1" user-id="{{$hierarchy->id}}"></i></a>
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
        <script src="{{ asset('admins-section/steps/oc_structure.js') }}" defer></script>
@endsection