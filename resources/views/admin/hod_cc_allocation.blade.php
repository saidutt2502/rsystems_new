@extends('layouts.admin-master')

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
        <th class="detail-col">Allocations</th>
        <th>Employee Id</th>
        <th>Employee Name</th>
    </tr>
    </thead>
    <tbody>
    @if($users)
        @foreach($users as $user)
        <?php
 
           
        $costcenters = DB::table('rs_costcenters')
        ->join('rs_departments','rs_departments.id','=','rs_costcenters.department')
        ->join('rs_location2department','rs_location2department.department','=','rs_departments.id')
        ->where('rs_departments.hod_id',$hod)
        ->where('rs_location2department.location',$user->location)
        ->select('rs_costcenters.number','rs_costcenters.id')
        ->get();

        
        $modules=DB::table('rs_modules')
        ->join('rs_departments','rs_departments.id','=','rs_modules.department')
        ->join('rs_location2department','rs_location2department.department','=','rs_departments.id')
        ->where('rs_departments.hod_id',$hod)
        ->where('rs_location2department.location',$user->location)
        ->select('rs_modules.name','rs_modules.id')
        ->get();

        $entries=DB::table('rs_cc2modules')
        ->join('rs_costcenters','rs_costcenters.id','=','rs_cc2modules.costcenter')
        ->join('rs_modules','rs_modules.id','=','rs_cc2modules.module')
        ->where('rs_cc2modules.user',$user->id)
        ->select('rs_costcenters.number','rs_costcenters.id','rs_cc2modules.budget','rs_cc2modules.actual','rs_modules.name as m_name','rs_modules.id as m_id','rs_cc2modules.id as cc2m_id')
        ->get();

        ?>
        <tr>
            <td class="center">
                <div class="action-buttons">
                    <a href="#" class="green bigger-140 show-details-btn" title="Show Allocations">
                        <i class="ace-icon fa fa-angle-double-down"></i>
                        <span class="sr-only">Allocations</span>
                    </a>
                </div>
            </td>
            <td>
                <a href="#!">{{$user->emp_id}}</a>
            </td>
            <td><a href="#!">{{$user->name}}</a></td>

        </tr>
        <tr class="detail-row">
            <td colspan="8">
            <div class="row">
		<div class="col-xs-12 col-sm-4 col-sm-offset-4">
				<div class="widget-box hidden-480">
					   <div class="widget-header">
							<h4 class="widget-title"></h4>
						</div>

						<div class="widget-body">
							   <div class="widget-main">
									<div>
										<label for="form-field-8">Cost Center</label>

											<select class="chosen-select form-control" id="{{$user->id}}_cc">
                                                 <option value="" disabled selected>Select Cost Center</option>
                                                 @if($costcenters)
                                                         @foreach($costcenters as $costcenter)
                                                          <option value="{{$costcenter->id}}">{{$costcenter->number}}</option>
                                                        @endforeach
                                                     @endif
                                                             
                                            </select>
									</div>

									<hr />

									<div>
										<label for="form-field-9">Module</label>

											<select class="chosen-select form-control" id="{{$user->id}}_module">
                                                <option value="" disabled selected>Select Module</option>
                                                @if($modules)
                                                         @foreach($modules as $module)
                                                             <option value="{{$module->id}}">{{$module->name}}</option>
                                                         @endforeach
                                                     @endif    
                                                             
                                            </select>
									</div>

                                    <hr />
                                    
                                    <div>
										<label for="form-field-11">Budget</label>

										<input type="text" class="form-control" id="{{$user->id}}_budget">
                                    </div>

                                    <hr />

									<div>
										<label for="form-field-11"></label>

											<center><button class="btn btn-default allocate_cc" user-id="{{$user->id}}">Allocate</center>
									</div>
								</div>
						</div>
				</div>
        </div>
    </div> 
            <br>
            <table id="{{$user->id}}_table" class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>Cost Center</th>
        <th>Module</th>
        <th>Budget</th>
        <th>Actual</th>
        <th class="hidden-480"></th>
    </tr>
    </thead>
    <tbody>
    @if($entries)
        @foreach($entries as $entry)
        <tr id="{{$entry->cc2m_id}}_entries">
            <td>
               {{$entry->number}}
            </td>
            <td>{{$entry->m_name}}</td>
            <td contenteditable class="edit_budget" entry-id="{{$entry->cc2m_id}}">{{$entry->budget}}</td>
            <td>{{$entry->actual}}</td>
            <td class="hidden-480">
                <center>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-danger delete_allocation" entry-id="{{$entry->cc2m_id}}">
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
        <script src="{{ asset('admins-section/steps/hod_cc_allocation.js') }}" defer></script>
@endsection