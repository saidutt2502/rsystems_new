@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Safety</li>
@endsection


@section('page-header')
    <h1>Safety
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;History</small>
    </h1>
    <div class="input-field pull-right">
        <a href="/shoes-request"><button class="btn btn-danger pull-right">Request Shoes<i class="ace-icon fa fa-arrow-right icon-on-right"></i></button></a>
    </div>
@endsection

@section('main-content')
<br><br>
    <div class="clearfix">
        <div class="pull-right tableTools-container"></div>
    </div>
    <div>
        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Brand Name</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Emp Id's</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if($request)
                    @foreach($request as $each_request)
                        <tr>
                            <td>{{ date("D, d F Y",strtotime($each_request->pickup_date))}}</td>
                            <td>{{$each_request->brand_name}}</td>
                            <td>{{$each_request->size}}</td>
                            <td>{{$each_request->quantity}}</td>
                            <td>{{$each_request->emp_id}}</td>
                            <td>{!!html_entity_decode($each_request->html_status)!!}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>


        
<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('safety_ajax')}}" id="url_ajax">

    <!-- Modal -->
<div id="confirm_delete_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirm delete Item?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="confirm_delete">Confirm</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
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