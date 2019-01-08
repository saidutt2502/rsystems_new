@extends('layouts.user-master')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('admins-section/steps/step.css') }}" />
@endsection


@section('breadcrumb')
    <li class="active">Module Information</li>
@endsection


@section('page-header')
    <h1>Modules
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Admins</small>
    </h1>
@endsection

@section('main-content')
 
  <br>

<table id="simple-table" class="table  table-bordered table-hover">
    <thead>
    <tr>
        <th class="detail-col">Details</th>
        <th>Department Name</th>
        <th>Location</th>
    </tr>
    </thead>
    <tbody>
    @if($departments)
        @foreach($departments as $department)
        <?php
        $dept2loc = DB::table('rs_location2department')->where('department',$department->id)->first();
        $deptname = DB::table('rs_departments')->where('id',$dept2loc->department)->value('name');
        $location = DB::table('rs_locations')->where('id',$dept2loc->location)->value('name');
        $modules = DB::table('rs_modules_programmer')->where('department_name',$deptname)->get();
        $users=DB::table('users')->join('rs_location2users','rs_location2users.user_id','=','users.id')->where('rs_location2users.location_id',$dept2loc->location)->select('users.*')->get();
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
                <a href="#!">{{$deptname}}</a>
            </td>
            <td><a href="#!">{{$location}}</a></td>

        </tr>
        <tr class="detail-row">
            <td colspan="8">
                     @if($modules)
                        @foreach($modules as $each_modules)
                        <div class="col-xs-12 col-sm-7 col-sm-offset-2 ">
                            <div class="well well-sm">
                                <h5>{{ $each_modules->module_name }}</h5> 
                                    <div class="col-xs-4 col-sm-4 col-sm-4">
                                        <select class="chosen-select form-control add_admin"  data-placeholder="Select Admin..." data-moduleID="{{ $each_modules->id}}" dept-id="{{ $department->id}}">
                                            <option value="">  </option>
                                            @foreach($users as $each_user)
                                                <option value="{{$each_user->id}}">{{$each_user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if($admins)
                                        @foreach($admins as $each_admin)
                                            @if($each_admin->department == $department->id && $each_admin->module_id == $each_modules->id )
                                                <div class="col-xs-4 col-sm-4 col-sm-4">
                                                    <select class="chosen-select form-control add_admin"  data-placeholder="Select Admin..."
                                                    data-tbid = "{{$each_admin->id}}" data-adminID = "{{$each_admin->user_id}}" 
                                                    data-moduleID="{{ $each_modules->id}}">
                                                        <option value="">  </option>
                                                        @foreach($users as $each_user)
                                                            <option value="{{$each_user->id}}">{{$each_user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
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
        <h4 class="modal-title">Admin Assigned !</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

@endsection

@section('js-files')
    <!-- Custom File -->
        <script src="{{ asset('admins-section/steps/admin_module.js') }}" defer></script>
@endsection