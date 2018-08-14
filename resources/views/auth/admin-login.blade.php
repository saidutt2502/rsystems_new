@extends('layouts.master')

@section('css-files')
@endsection

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                    <span class="card-title center-align">Admin Login</span>
                        <p>
                            <div class="row">
                            <form method="POST" class="col s12" action="{{ route('admin.login.submit') }}" aria-label="{{ __('Login') }}" autocomplete="off">
                        @csrf
                                    <div class="row">
                                        <div class="input-field col s12 m12 ">
                                        <i class="material-icons prefix">mode_edit</i>
                                        <input id="email" name="email" type="text" class="validate">
                                        <label for="email">Email</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m12">
                                        <i class="material-icons prefix">vpn_key</i>
                                        <input id="password" name="password" type="password" class="validate">
                                        <label for="password">Password</label>
                                        </div>
                                    </div>
                            </div>
                        </p>
                    </div>
                    <div class="card-action center-align">
                        <button class="btn waves-effect waves-light green darken-1" type="submit" name="action">Login
                            <i class="material-icons right">send</i>
                        </button>&nbsp;
                        <button class="btn waves-effect waves-light red darken-1" type="submit" name="action">Forgot Password
                            <i class="material-icons right">supervisor_account</i>
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>       
@endsection

@section('js-files')

@endsection