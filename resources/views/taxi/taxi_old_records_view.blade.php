@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Taxi</li>
@endsection


@section('page-header')
    <h1>Taxi
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Old Records</small>
    </h1>
@endsection

@section('main-content')
   
    <div class="clearfix">
            <div class="pull-right tableTools-container"></div>
        </div>
        <div>
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                          <th>Sr No.</th>
                          <th>Date</th>
                          <th>From</th>
                          <th>To</th>
                          <th>Lead Passenger</th>
                          <th>Total Kms</th>
                          <th>Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @if($records)
                    <?php
                    $i=1;
                    ?>
                        @foreach($records as $record)
                    <tr data-id="{{$record->id}}" >
                        <td>{{$i}}.</td>
                        <td>{{$record->ddate}}</td>
                        <td>{{$record->from}}</td>
                        <td>{{$record->to}}</td>
                        <td>{{$record->name}}</td>
                        <td>{{$record->totalkm}}</td>
                        <td>{{$record->cost}}</td>
                    </tr>
                    <?php
                    $i++;
                    ?>
                    @endforeach
                @endif
                <tr>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>Total Kms: Rs. {{$kms}}</td>
                    <td>Total Cost: Rs. {{$total}}</td>
                </tr>
                </tbody>
            </table>
        </div>

        


 

@endsection

@section('js-files')
    <!-- Custom File -->
    <script src="{{ asset('admins-section/steps/initialize_datatables.js') }}" defer></script>
    <script src="{{ asset('stationary/stationary.js') }}" defer></script>

    
    <script src="/core/js/jquery-ui.min.js"></script>
    <script src="/core/js/jquery.ui.touch-punch.min.js"></script>

    <script src="/core/js/jquery.dataTables.min.js"></script>
    <script src="/core/js/jquery.dataTables.bootstrap.min.js"></script>
    <script src="/core/js/dataTables.buttons.min.js"></script>
    <script src="/core/js/buttons.flash.min.js"></script>
    <script src="/core/js/buttons.html5.min.js"></script>
    <script src="/core/js/buttons.print.min.js"></script>
    <script src="/core/js/buttons.colVis.min.js"></script>
    <script src="/core/js/dataTables.select.min.js"></script>
@endsection