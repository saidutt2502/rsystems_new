@extends('layouts.admin-master')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('admins-section/steps/step.css') }}" />
@endsection

@section('main-content')
    <!-- page title hidden input type       -->
    <input type="hidden" value="{{ $name }} -> Users" id="page-title">

<div class="padding-sides">

    <div class="row hide-on-small-only">
        <div class="row">
        <div class="input-field col s2">
            <i class="material-icons prefix">card_membership</i>
            <input id="emp_id" placeholder="Employee Id" type="text" >
            </div>
            <div class="input-field col s3">
            <i class="material-icons prefix">mood</i>
            <input id="name" placeholder="Name" type="text" >
            </div>
            <div class="input-field col s4">
            <i class="material-icons prefix">email</i>
            <input id="email" placeholder="Email Address" type="text">
            </div>
            <div class="input-field col s3">
            <i class="material-icons prefix">lock_outline</i>
            <input id="password" placeholder="Password" type="password">
            </div>
        </div>
    </div>

    <div class="row center-align hide-on-small-only">
        <a id="add_user" class="waves-effect waves-light green darken-2 btn"><i class="material-icons left">send</i>Submit</a>
        <a id="reset" class="waves-effect waves-light red darken-2  btn"><i class="material-icons right">cloud</i>Reset</a>
    </div>

    <div class="divider"></div>

        <div class="row">
            <table class="striped responsive-table">
                <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th></th>
                </tr>
                </thead>

                <tbody id="user_list_table">
                    @if($users)
                        @foreach($users as $each_user)
                            <tr id="{{$each_user->id}}">
                                <td>{{$each_user->emp_id}}</td>
                                <td>{{$each_user->name}}</td>
                                <td>{{$each_user->email}}</td>
                                <td><i data-userid="{{$each_user->id}}"  class="material-icons remove-user">close</i></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div> 
    </div>

<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('step')}}" id="url_ajax">

<!-- More hidden values -->
<input type="hidden" value="{{ $id }}" id="location_id">


 <!-- Error Modal -->
 <div id="error_modal" class="modal red darken-1">
    <div class="modal-content">
      <h4 class="center-align"><strong id="error_msg">Please Enter all Details !</strong></h4>
    </div>
</div>

<!-- Confirm Action Modal -->
 <div id="confirm_modal" class="modal">
    <div class="modal-content">
      <h4 class="center-align">Delete user?</h4>
    </div>
    <div class="modal-footer">
      <a id="confirm_delete" class="modal-close waves-effect waves-green btn-flat">Agree</a>
      <a id="close" class="modal-close waves-effect waves-green btn-flat">Disagree</a>
    </div>
  </div>

@endsection

@section('js-files')
    <script src="{{ asset('admins-section/steps/loc_user.js') }}" defer></script>
@endsection
