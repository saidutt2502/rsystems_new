@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Gatepass</li>
@endsection

@section('css-files')
<link rel="stylesheet" href="/core/css/datatable1.css" />
<link rel="stylesheet" href="/core/css/datatable2.css" />
@endsection

@section('page-header')
    <h1>Report </h1>
@endsection

@section('main-content')
<table id="example" class="display" style="width:100%">
        <thead>
           
            <tr>
                <th>Date</th>
                <th>Employee Name</th>
                <th>Shift</th>
                <th>Purpose</th>
                <th>Reason</th>
                <th>Out Time</th>
                <th>In Time</th>
            </tr>
        </thead>
        <tbody>

            @foreach($result as $each_row)
            <tr>
                <td>{{$each_row->actualdatef}}</td>
                <td>{{$each_row->name}}</td>
                <td>{{$each_row->shift_name}}</td>
                <td>{{$each_row->purpose}}</td>
                <td>{{$each_row->reason}}</td>
                <td>{{$each_row->actualfrom}}</td>
                <td>@if($each_row->actualto){{$each_row->actualto}}@else No Return @endif</td>
            </tr>
            @endforeach
            </tbody>
    </table>
@endsection

@section('js-files')
    <!-- ace scripts -->
    <script src="/core/js/datatable1.js"></script>
    <script src="/core/js/datatable2.js"></script>
    <script src="/core/js/datatable3.js"></script>
    <script src="/core/js/datatable4.js"></script>
    <script src="/core/js/datatable5.js"></script>
    <script src="/core/js/datatable6.js"></script>
    <script src="/core/js/datatable7.js"></script>

<script>
        $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                // 'copyHtml5',
                // 'excelHtml5',
                // 'csvHtml5',
                // 'printHtml5',
                {
                    extend: 'pdfHtml5',
                    download: 'open',
                    pageSize: 'A4',
                }

            ]
        } );
    } );

</script>
    
@endsection