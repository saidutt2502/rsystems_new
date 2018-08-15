@extends('layouts.admin-master')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('admins-section/steps/step.css') }}" />
@endsection

@section('main-content')
    <!-- page title hidden input type       -->
    <input type="hidden" value="Cost Center Information" id="page-title">

<div class="padding-sides">

    <div class="row">
    <br><br>
    <ul class="collapsible">
    @foreach($departments as $each_department)
    <?php
    $dept2loc = DB::table('rs_location2department')->where('department',$each_department->id)->first();
    $deptname = DB::table('rs_departments')->where('id',$dept2loc->department)->value('name');
    $location = DB::table('rs_locations')->where('id',$dept2loc->location)->value('name');
    $costcenters = DB::table('rs_costcenters')->where('department',$each_department->id)->get();
    ?>
     <li>
    <div class="collapsible-header cc_collapsible"><i class="material-icons">chevron_right</i>{{$deptname}} ({{$location}})</div>
    <div class="collapsible-body"><span>
        
        <div class="row">
        <div class="input-field col s1">
        <i class="material-icons prefix add_cc" dept-id="{{$each_department->id}}">add</i>
        </div>
        <div class="input-field col s5">
          <input id="icon_prefix" type="text" class="validate cc_no">
          <label for="icon_prefix">Cost Center Number and Name</label>
        </div>
        </div>

        <div class="divider"></div>

<div class="row">
    <table class="striped">
        <thead>
        <tr>
            <th>Cost Center List</th>
            <th></th>
        </tr>
        </thead>
        <tbody id="cc_list_table_{{$each_department->id}}">
            @foreach($costcenters as $costcenter)
                <tr id="{{$costcenter->id}}">
                    <td>{{$costcenter->number}}</td>
                    <td><i class="material-icons remove-cc" cc-id="{{$costcenter->id}}">close</i></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> 

        
    </span>
    </div>
    </li>
    @endforeach
    </ul>    
    </div> 
</div>

<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('step')}}" id="url_ajax">


@endsection

@section('js-files')
    <script src="{{ asset('admins-section/steps/hod_cc.js') }}" defer></script>
@endsection