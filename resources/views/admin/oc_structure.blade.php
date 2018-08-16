@extends('layouts.admin-master')

@section('css-files')
<link rel="stylesheet" href="{{ asset('admins-section/steps/step.css') }}" />
@endsection

@section('main-content')

    <!-- page title hidden input type       -->
<input type="hidden" value="Location -> Departments" id="page-title">
<input type="hidden" id="hod_id" value="{{$hodid}}">
<div class="padding-sides">

    <div class="row hide-on-small-only">
        <div class="row">
             <div class="input-field col s6">
             <select id ="dept">
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
            </div>
            <div class="input-field col s6">
             <select id="levels">
             <option class="to_remove" value="" disabled selected>Select Line</option>
             </select>
            <label>Line to Initialize</label>
            </div>
        </div>
    </div>
    <div class="divider"></div>
    <div id="add_table"></div>
</div> 

<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('step')}}" id="url_ajax">


@endsection

@section('js-files')
<script src="{{ asset('admins-section/steps/oc_structure.js') }}" defer></script>
@endsection