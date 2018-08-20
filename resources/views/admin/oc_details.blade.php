@extends('layouts.admin-master')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('admins-section/steps/step.css') }}" />
@endsection

@section('breadcrumb')
    <li class="active">Organisation Chart</li>
@endsection


@section('page-header')
<ul class="nav nav-tabs">
  <li class="active"><a href="oc">OC Details</a></li>
  <li><a href="oc_structure">OC Structure</a></li>
  
</ul>
@endsection

@section('main-content')

  <br>
  <table id="simple-table" class="table  table-bordered table-hover">
    <thead>
    <tr>
        <th>Name</th>
        <th>Location</th>
        <th>Levels</th>
        <th class="hidden-480"></th>
    </tr>
    </thead>
    <tbody>
    @if($departments)
        @foreach($departments as $department)
        <?php
        $dept2loc = DB::table('rs_location2department')->where('department',$department->id)->first();
        $deptname = DB::table('rs_departments')->where('id',$dept2loc->department)->value('name');
        $levels = DB::table('rs_departments')->where('id',$dept2loc->department)->value('oc_levels');
        $location = DB::table('rs_locations')->where('id',$dept2loc->location)->value('name');
        $costcenters = DB::table('rs_costcenters')->where('department',$department->id)->get();
    ?>   
        <tr>
            <td>
                <a href="#!">{{$deptname}}</a>
            </td>
            <td><a href="#!">{{$location}}</a></td>
            <td><span class="badge badge-info">{{$levels}}</span></td>
            <td class="hidden-480">
                <center>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-info edit-modal" dept-id="{{$department->id}}">
                            <i class="ace-icon fa fa-pencil bigger-120"></i>
                        </button>
                    </div>
                </center>
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
        <h4 class="modal-title">Levels</h4>
      </div>
      <div class="modal-body">
      <div class="input-group hidden-480">
        <span class="input-group-addon"><i class="ace-icon fa fa-gavel"></i></span>
        <input class="form-control" id="levels" placeholder="Number of Levels" type="text">
        <input class="form-control" id="dept" type="hidden">
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="confirm_delete">Add</button>
      </div>
    </div>

  </div>
</div>

@endsection

@section('js-files')
    <!-- Custom File -->
        <script src="{{ asset('admins-section/steps/oc_details.js') }}" defer></script>
@endsection