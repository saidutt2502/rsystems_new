@extends('layouts.admin-master')

@section('breadcrumb')
    <li class="active">Step-2</li>
@endsection


@section('page-header')
    <h1>{{ $name }}
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Users</small>
    </h1>
@endsection

@section('main-content')
    <div class="widget-box hidden-480">
            <div class="widget-header">
                <h4 class="widget-title">Add Users</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-inline">
                        <span class="input-icon">
                            <input id="emp_id" placeholder="Employee Code" type="text">
                            <i class="ace-icon fa fa-key blue"></i>
                        </span>
                        <span class="input-icon">
                            <input id="name" placeholder="Name" type="text">
                            <i class="ace-icon fa fa-users blue"></i>
                        </span>
                        <span class="input-icon">
                            <input id="email" placeholder="Email" type="text">
                            <i class="ace-icon fa fa-briefcase blue"></i>
                        </span>
                        <span class="input-icon">
                            <input id="password" placeholder="Password" type="text">
                            <i class="ace-icon fa  fa-eye  red"></i>
                        </span>
                        <span class="input-icon">
                        <?php
                         $user_types=DB::table('users_type')->get();
                        ?>
                        <select  id="user_type_id" class="chosen-container chosen-container-single chosen-select">
                            <option value="" disabled selected>Select User Type</option>
                                @foreach($user_types as $type)
                                <option value="{{$type->id}}">{{$type->type}}</option>
                                @endforeach
                        </select>
                        </span>
                      
                        <button type="button" id="add_user" class="btn btn-info btn-sm">
                            <i class="ace-icon fa fa-check bigger-110"></i>Add
                        </button>
                        <button type="button" id="reset" class="btn btn-danger btn-sm">
                            <i class="ace-icon fa fa-stop bigger-110"></i>Reset
                        </button>
                    </form>
                </div>
            </div>
    </div>
    <br>
        <div class="clearfix">
            <div class="pull-right tableTools-container"></div>
        </div>
        <div>
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Empoyee Code</th>
                        <th class="hidden-480">Name</th>
                        <th class="hidden-480">Email</th>
                        <th class="hidden-480">User Type</th>
                        <th class="hidden-480">
                            <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                            Updated
                        </th>
                        <th class="hidden-480">Status</th>
                        <th class="hidden-480"></th>
                    </tr>
                </thead>

                <tbody>
                    @if($users)
                        @foreach($users as $each_user)
                        <?php
                        $user_type=DB::table('users_type')->where('id',$each_user->user_type_id)->value('type');
                        ?>
                    <tr>
                        <td>
                            <a href="#">{{$each_user->emp_id}}</a>
                        </td>
                        <td class="hidden-480">{{$each_user->name}}</td>
                        <td class="hidden-480">{{$each_user->email}}</td>
                        <td class="hidden-480">{{$user_type}}</td>
                        <td class="hidden-480">@if($each_user->updated_at){{ date("D, d F Y",strtotime($each_user->updated_at))}}@endif</td>

                        <td class="hidden-480">
                            <span class="label label-sm label-success">Active</span>
                        </td>

                        <td class="hidden-480">
                            <div class="hidden-sm hidden-xs action-buttons">
                                <a class="green" href="#">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>

                                <a class="red remove-user" href="#" data-userid="{{$each_user->id}}">
                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>

    <!-- Modal -->
<div id="confirm_delete_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirm delete User?</h4>
      </div>
      <div class="modal-body">
        <p>Deleting this User will only delete this user from this departments.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="confirm_delete">Confirm</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

        <!-- Location Id -->
        <input type="hidden" value="{{ $id }}" id="location_id">

    <!-- Ajax call url       -->
    <input type="hidden" value="{{URL::to('step')}}" id="url_ajax">

@endsection

@section('js-files')
    <!-- Custom File -->
    <script src="{{ asset('admins-section/steps/initialize_datatables.js') }}" defer></script>
    <script src="{{ asset('admins-section/steps/loc_user.js') }}" defer></script>

    <script src="/core/js/jquery-ui.min.js"></script>
    <script src="/core/js/jquery.ui.touch-punch.min.js"></script>

    <script src="/core/js/jquery.dataTables.min.js"></script>
    <script src="/core/js/jquery.dataTables.bootstrap.min.js"></script>
    <script src="/core/js/dataTables.buttons.min.js"></script>
    <script src="/core/js/buttons.flash.min.js"></script>
    <script src="/core/js/buttons.html5.min.js"></script>
    <script src="/core/js/buttons.print.min.js"></script>
    <script src="/core/js/buttons.colVis.min.js"></script>
    <script src="/core/js/dataTables.select.min.js"></script>
@endsection
