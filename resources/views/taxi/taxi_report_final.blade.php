@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Taxi</li>
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
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>

            @foreach($result as $each_row)
            <tr>
                <td>{{$each_row->item_name}}</td>
                <td>{{$each_row->cc_number}}</td>
                <td>{{$each_row->item_name}}</td>
                <td>{{$each_row->remarks}}</td>
                <td>{{$each_row->item_name}}</td>
                <td>{{$each_row->cc_number}}</td>
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
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                {
                    extend: 'pdfHtml5',
                    download: 'open'
                }

            ]
        } );
    } );

</script>
    
@endsection