@extends('layouts.user-master')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('admins-section/steps/step.css') }}" />
@endsection

@section('breadcrumb')
    <li class="active">Organisation Chart</li>
@endsection


@section('page-header')
<!-- <ul class="nav nav-tabs">
  <li><a href="oc">OC Details</a></li>
  <li class="active"><a href="oc_structure">OC Structure</a></li>
  
</ul> -->
<h1>Organisation Chart
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Initialization</small>
</h1>
@endsection

@section('main-content')

<input type="hidden" id="dept" value="{{$departments}}">
<input type="hidden" id="levels" value="{{$level}}">
<input type="hidden" id="hod_id" value="{{$hodid}}">

<span class="label label-inverse">{{$deptname}} ({{$location->name}})</span>
<span class="label label-inverse">2nd Line</span>

<br><br>
  
  <div class="widget-box hidden-480">
            <div class="widget-header">
                <h4 class="widget-title"></h4>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-inline">
                    <select class="chosen-select form-control" id="user_id">
                        <option value="" disabled selected>Select User</option>
                             @if($users)
                                @foreach($users as $user)
                                            
                                     <option value="{{$user->id}}">{{$user->name}} (Emp Id: {{$user->emp_id}})</option>
                                @endforeach
                             @endif         
                    </select><br><br>
                      
                        <center>
                        <button type="button" id="add_emp" class="btn btn-info btn-sm">
                            <i class="ace-icon fa fa-check bigger-110"></i>Add
                        </button>
                        </center>
                    </form>
                </div>
            </div>
    </div>
  
 <br>
  <table id="added_employees" class="table  table-bordered table-hover">
    <thead>
    <tr>
        <th>Employee Id</th>
        <th>Employee Name</th>
        <th class="hidden-480"></th>
    </tr>
    </thead>
    <tbody>
    @if($hierarchies)
        @foreach($hierarchies as $hierarchy) 
        <tr id="{{$hierarchy->r_id}}">
            <td>
                <a href="#!">{{$hierarchy->emp_id}}</a>
            </td>
            <td><a href="#!">{{$hierarchy->name}}</a></td>
            <td class="hidden-480">
                <center>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-danger del_emp" entry-id="{{$hierarchy->r_id}}">
                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
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
        <script src="{{ asset('admins-section/steps/oc_structure.js') }}" defer></script>
@endsection