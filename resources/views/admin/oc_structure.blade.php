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

  <br>
  <form method="POST" action="/admin/oc_structure_1">
  {{ csrf_field() }}

  <div class="row">
		<div class="col-xs-12 col-sm-4 col-sm-offset-4">
				<div class="widget-box">
					   <div class="widget-header">
							<h4 class="widget-title"></h4>
						</div>

						<div class="widget-body">
							   <div class="widget-main">
									<div>
										<label for="form-field-8">Department</label>

											<select class="chosen-select form-control" id="dept" name="dept_id">
                                            <option value="" disabled selected>Select Department</option>
                                            @if($departments)
                                                 @foreach($departments as $department)
                                                     <?php
                                                     $dept2loc = DB::table('rs_location2department')->where('department',$department->id)->first();
                                                     $deptname = DB::table('rs_departments')->where('id',$dept2loc->department)->value('name');
                                                     $location = DB::table('rs_locations')->where('id',$dept2loc->location)->value('name');
                                                     ?>
                                                     <option value="{{$department->id}}">{{$deptname}} ({{$location}})</option>
                                                 @endforeach
                                            @endif         
                                            </select>
									</div>

									<hr />

									<div>
										<label for="form-field-9">Line to Initialize</label>

											<select class="chosen-select form-control" id="levels" name="level_selected">
                                            <option class="to_remove" value="" disabled selected>Select Line</option>
                                            <option value="2">2nd Line</option>
                                            <option value="3">3rd Line</option>
                                            </select>
									</div>

									<hr />

									<div>
										<label for="form-field-11"></label>

											<center><input type="submit" class="btn btn-default" value="Go"></center>
									</div>
								</div>
						</div>
				</div>
        </div>
    </div> 
   </form>   
                                        
  



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