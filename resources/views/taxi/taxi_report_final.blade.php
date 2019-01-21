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
                <th>Date</th>
                <th>Lead Passenger</th>
                <th>From</th>
                <th>To</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Total Kms</th>
                <th>Wait Cost</th>
                <th>Night Cost</th>
                <th>Mid-Night Cost</th>
                <th>Extra Cost</th>
                <th>Total Cost</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>

            @foreach($result as $each_row)
            <tr>
                <td>{{$each_row->start_date}}</td>
                <td>{{$each_row->user_name}}</td>
                <td>{{$each_row->place_from}}</td>
                <td>{{$each_row->place_to}}</td>
                <td>{{$each_row->start_time}}</td>
                <td>{{$each_row->end_time}}</td>
                <td>{{$each_row->total_km}}</td>
                <td>{{$each_row->wait_time*$each_row->waiting}}</td>
                <td>@if($each_row->night=='1'){{$each_row->night_charge}}@else 0 @endif</td>
                <td>@if($each_row->midnight=='1'){{$each_row->midnight_charge}}@else 0 @endif</td>
                <td>{{$each_row->extra_cost}}</td>
                <td>{{$each_row->cost}}</td>
                <td>{{$each_row->remarks}}</td>
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