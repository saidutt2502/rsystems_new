@extends('layouts.admin-master')

@section('breadcrumb')
    <li class="active">Dashboard</li>
@endsection

@section('css-files')
        <link rel="stylesheet" href="{{ asset('admins-section/admin.css') }}" />
@endsection

@section('main-content')
        <!-- <ol class="organizational-chart">
        <li>
            <div>
                <h1><b>Rosenberger India</b></h1>
            </div>
            <li>
                <ol>
            @if($location)
                @foreach($location as $each_location)
                    <li>
                        <div>
                            <h2>{{$each_location->name}}</h2>
                        </div>
                            @if($deptlocation)
                                <ol>
                                    @foreach($deptlocation as $each_dept)
                                        @if($each_dept->location_id == $each_location->id)
                                            <li>
                                                <div>
                                                    <h3>{{$each_dept->name}}</h3>
                                                </div>
                                            </li>       
                                        @endif                 
                                    @endforeach
                                </ol>
                            @endif
                    </li>
                @endforeach
            @endif
                  
        </ol> -->
@endsection