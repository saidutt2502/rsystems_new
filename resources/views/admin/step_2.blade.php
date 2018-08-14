@extends('layouts.admin-master')

@section('main-content')
    <!-- page title hidden input type       -->
    <input type="hidden" value="Locations -> Users" id="page-title">

    <div class="container">
        <div class="row">
            @if($location)
                @foreach($location as $e_location)
                    <a href="/admin/loc/{{ $e_location->id }}">
                        <div class="col s12 m4">
                            <div class="card-panel teal">
                                <span class="white-text"><h4 class="center-align">{{ $e_location->name }}</h4></span>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
        </div> 
    </div>      
@endsection
