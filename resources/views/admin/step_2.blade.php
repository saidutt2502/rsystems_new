@extends('layouts.admin-master')

@section('breadcrumb')
    <li class="active">User Master</li>
@endsection


@section('page-header')
    <h1>Locations
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Users</small>
    </h1>
@endsection

@section('main-content')
<table id="simple-table" class="table  table-bordered table-hover">
    <thead>
    <tr>
        <th class="hidden-480">Sr.no</th>
        <th>Location</th>
        <th>Users</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @if($location)
        @foreach($location as $key => $value )
        <tr>
            <td class="hidden-480">
                <a href="#!">{{ $key+1 }}</a>
            </td>
            <td>
                <a href="#!">{{ $value->name }}</a>
            </td>

            <td>
            <span class="badge badge-success">{{ $value->count }}</span>
            </td>
            <td>
                <center>
                    <div class="btn-group">
                       <a href="/admin/loc/{{ $value->id }}"> <button class="btn btn-sm btn-info">
                            <i class="ace-icon fa fa-pencil bigger-120"></i>
                        </button></a>
                    </div>
                </center>
            </td>
        </tr>
        @endforeach
    @endif
    </tbody>
</table>

@endsection
