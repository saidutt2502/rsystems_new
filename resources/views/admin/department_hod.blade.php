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
                    <th></th>
                </tr>
                </thead>

                <tbody>
                    @if($departments)
                        @foreach($departments as $each_department)
                            <tr id="{{$each_department->id}}">
                                <td>{{$each_department->name}}</td>
                                     @if($each_department->hod_id==NULL)
                                    <td colspan='2'>
                                    <div class="input-field col s12">
                                    <select class="add_hod" dept-id="{{$each_department->id}}">
                                    <option value="" disabled selected>Select HOD</option>
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                    </select>
                                    </div>
                                    </td>
                                    @else
                                    <?php
                                    $name=DB::table('users')->where('id',$each_department->hod_id)->value('name');
                                    ?>
                                    <td>
                                    {{$name}}
                                    </td>
                                    <td>
                                    <center><i class="material-icons prefix delete_hod" dept-id="{{$each_department->id}}" user-id="{{$each_department->hod_id}}">close</i></center>
                                    </td>
                                @endif
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