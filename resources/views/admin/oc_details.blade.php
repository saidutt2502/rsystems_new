@extends('layouts.admin-master')

@section('css-files')
<link rel="stylesheet" href="{{ asset('admins-section/steps/step.css') }}" />
@endsection

@section('main-content')
    <!-- page title hidden input type       -->
    <input type="hidden" value="Location -> Departments" id="page-title">
    <div class="container">
        <div class="row">
           <div class="col s12 m6">
           <div class="card-panel teal" id="oc_details">
           <span class="white-text"><h4 class="center-align">Organisation Chart Details</h4></span>
           </div>
           </div>
        </div>
        <div class="row">
           <a href="/admin/oc_structure">
           <div class="col s12 m6">
           <div class="card-panel teal">
           <span class="white-text"><h4 class="center-align">Organisation Chart Structure</h4></span>
           </div>
           </div>
           </a>   
        </div> 
    </div> 

<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('step')}}" id="url_ajax">

 <!-- Modal Structure -->
<div id="modal1" class="modal">
    <div class="modal-header" style="padding-top:20px">
        <h4><center>Organisation Chart Details</center</h4>
    </div>
    <div class="divider"></div>
    <div class="modal-content">
        <div class="input-field">
            <select id="dept">
                    <option value="" disabled selected>Select Department</option>
                        @if($departments)
                            @foreach($departments as $department)
                             <?php
                             $dept2loc = DB::table('rs_location2department')->where('department',$department->id)->first();
                             $location = DB::table('rs_locations')->where('id',$dept2loc->location)->value('name');
                             ?>
                            <option value="{{$department->id}}">{{$department->name}} ({{$location}})</option>
                            @endforeach
                        @endif   
            </select>
            <label>Department</label>
            <br>
        </div>
        <div class="input-field">
        <input type="text" id="levels">
        <label for="levels">Number of Levels</label>
        <br>
        </div>
    </div>
    <div class="modal-footer">
      <button class="btn-flat" id ="submit">Done</a>
    </div>
</div>

@endsection

@section('js-files')
<script src="{{ asset('admins-section/steps/oc_details.js') }}" defer></script>
@endsection