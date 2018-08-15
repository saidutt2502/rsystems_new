@extends('layouts.admin-master')

@section('css-files')
<link rel="stylesheet" href="{{ asset('admins-section/steps/step.css') }}" />
@endsection

@section('main-content')
    <!-- page title hidden input type       -->
    <input type="hidden" value="Location -> Departments" id="page-title">

    <div class="container">
        <div class="row">
            <div class = "col m6">
                <ul class="collection with-header" id="location_collection">
                 <li class="collection-header"><h4>Locations</h4></li>
                    <li class="collection-item">
                        <div class="input-field">
                            <i class="material-icons prefix" id="add_location_ico">add</i>
                            <input type="text" class="validate location_name">
                        </div>
                    </li>
                    @if($location)
                        @foreach($location as $e_location)
                            <li class="collection-item avatar ">
                                <i remove-id="{{$e_location->id}}" class="material-icons circle red delete_location">remove</i>
                                <span class="title">{{$e_location->name}}</span>
                                <!-- <p>First Line</p> -->
                                <a href="#!" open-id="{{$e_location->id}}" class="secondary-content  add_dept2location"><i class="material-icons">send</i></a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div> 
            <div class = "col m6">
            <ul class="collection with-header" id="department_collection">
                 <li class="collection-header"><h4>Departments</h4></li>
                    <li class="collection-item">
                        <div class="input-field">
                            <i class="material-icons prefix" id="add_department_ico">add</i>
                            <input type="text" class="validate department_name">
                        </div>
                    </li>
                </ul>
            </div> 
        </div>
    </div>

<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('step')}}" id="url_ajax">

 <!-- Modal Structure -->
 <div id="modal1" class="modal">
    <div class="modal-content">
      <h4 class="center-align">Please Select Location</h4>
    </div>
</div>

 <!-- Error Modal -->
 <div id="error_modal" class="modal red darken-1">
    <div class="modal-content">
      <h4 class="center-align" id="error_msg"></h4>
    </div>
</div>

@endsection

@section('js-files')
<script src="{{ asset('admins-section/steps/step.js') }}" defer></script>
@endsection