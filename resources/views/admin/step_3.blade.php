@extends('layouts.admin-master')

@section('css-files')
<link rel="stylesheet" href="{{ asset('admins-section/steps/step.css') }}" />
@endsection

@section('breadcrumb')
    <li class="active">Hod Information</li>
@endsection


@section('page-header')
    <h1>Departments
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Hod</small>
    </h1>
@endsection

@section('main-content')

<table id="simple-table" class="table  table-bordered table-hover">
    <thead>
    <tr>
        <th class="detail-col">Details</th>
        <th>Location</th>
        <th>Departments</th>
        <th class="hidden-480">Status</th>
        <th class="hidden-480"></th>
    </tr>
    </thead>
    <tbody>
    @if($location)
        @foreach($location as $each_location)
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
                <a href="#!">{{ $each_location->name }}</a>
            </td>
            <td><span class="badge badge-info">{{ $each_location->count }}</span></td>

            <td class="hidden-480">
            <span class="label label-success arrowed-in arrowed-in-right">Online</span>
            </td>
            <td class="hidden-480">
                <center>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-info">
                            <i class="ace-icon fa fa-pencil bigger-120"></i>
                        </button>

                        <button class="btn btn-sm btn-danger delete_location" data-location-id="{{ $each_location->id }}" >
                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                        </button>
                    </div>
                </center>
            </td>
        </tr>
        <tr class="detail-row">
            <td colspan="8">
                    @if($deptlocation)
                        @foreach($deptlocation as $each_dept)
                            @if( $each_location->id == $each_dept->location_id)
                                    <div class="col-xs-12 col-sm-7 col-sm-offset-2 ">
                                    <div class="well well-sm">
                                         <h5>{{ $each_dept->name }}</h5> 
                                            <div class="col-xs-12 col-sm-12 col-sm-12">
                                                <select class="chosen-select form-control add_hod" data-dept-id="{{$each_dept->id}}" data-hod="{{$each_dept->hod_id}}" data-placeholder="Select Head of Department...">
                                                                            <option value="">  </option>
                                                                            @foreach($users as $each_user)
                                                                                <option value="{{$each_user->id}}">{{$each_user->name}}</option>
                                                                            @endforeach
                                                </select>
                                            </div>
                                    </div>
                                    
                                    </div>
                                </div>
                            @endif
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
        <script src="{{ asset('admins-section/steps/dept_hod.js') }}" defer></script>
@endsection