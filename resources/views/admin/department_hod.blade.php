@extends('layouts.admin-master')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('admins-section/steps/step.css') }}" />
@endsection

@section('main-content')
    <!-- page title hidden input type       -->
    <input type="hidden" value="{{ $name }} -> Users" id="page-title">

<div class="padding-sides">

    <div class="row">
            <table class="striped">
                <thead>
                <tr>
                    <th>Department Name</th>
                    <th>HOD Name</th>
                </tr>
                </thead>

                <tbody id="user_list_table">
                    @if($departments)
                        @foreach($departments as $each_department)
                            <tr id="{{$each_department->id}}">
                                <td>{{$each_department->name}}</td>
                                <td>
                                <div class="input-field col s1">
                                <i  data-deptid="{{$each_department->id}}" class="material-icons prefix add_hod">add</i>
                                </div>
                                <div class="input-field col s11">
                                <input type="text" id="autocomplete-input" class="autocomplete">
                                </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div> 
    </div>

<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('step')}}" id="url_ajax">


@endsection

@section('js-files')
    <script src="{{ asset('admins-section/steps/dept_hod.js') }}" defer></script>
@endsection