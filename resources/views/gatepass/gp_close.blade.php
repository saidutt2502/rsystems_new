@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Gatepass</li>
@endsection


@section('page-header')
    <h1>Gatepass
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Closing</small>
    </h1>
@endsection

@section('main-content')

<div class="row">
    <div class="col-sm-12">
        <div class="tabbable">
            

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-xs-12">
                            @if($details)
                                @foreach($details as $detail)
                            <div class="media search-media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object" data-src="holder.js/72x72" alt="72x72" style="width: 72px; height: 72px;" src="/core/images/avatars/avatar2.png" data-holder-rendered="true">
                                    </a>
                                </div>

                                <div class="media-body">
                                    <p>
                                    User:&nbsp;<b>{{$detail->name}}&nbsp;(Employee Code:&nbsp;{{$detail->emp_id}})</b>&nbsp;&nbsp;</b><br>
                                    Date:&nbsp;<b><span>{{ date("D, d F Y",strtotime($detail->date_))}}</span></b>&nbsp;&nbsp;|&nbsp;&nbsp;Time:<b>{{$detail->from}} - @if($detail->to){{$detail->to}} @else No Return @endif</b>
                                    @if($detail->status=='6')
                                    <br>Actual Out :&nbsp;<b>{{$detail->actualfrom}}&nbsp;
                                    @endif
                        
                                    </p>
                                    @if($detail->status=='2')
                                    <div class="search-actions text-center">
                                        <br><a class="btn btn-sm btn-block btn-danger close-btn" data-uniqueID="{{$detail->id}}">Out Time</a>
                                    </div>
                                    @endif
                                    @if($detail->status=='6')
                                    <div class="search-actions text-center">
                                        <br><a class="btn btn-sm btn-block btn-primary close-in-btn" data-uniqueID1="{{$detail->id}}">In Time</a>
                                    </div>
                                    @endif
                                </div>    
                            </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>
    <!-- /.col -->
</div>
    
<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('gatepass_ajax')}}" id="url_ajax">

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Out Time Details</h4>
      </div>
      <div class="modal-body col-md-12">
      <div class="input-group hidden-480">
        <span class="input-group-addon"><i class="ace-icon fa fa-clock-o"></i></span>
        <input class="form-control" id="date" type="date">
        <input class="form-control" id="time" type="time">
        <input class="form-control" id="entry_id" type="hidden">
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="confirm_close">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">In Time Details</h4>
      </div>
      <div class="modal-body col-md-12">
      <div class="input-group hidden-480">
        <span class="input-group-addon"><i class="ace-icon fa fa-clock-o"></i></span>
        <input class="form-control" id="date1" type="date">
        <input class="form-control" id="time1" type="time">
        <input class="form-control" id="entry_id1" type="hidden">
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="confirm_close_in">Close</button>
      </div>
    </div>

  </div>
</div>

@endsection

@section('js-files')
        <script src="{{ asset('gatepass/gp_close.js') }}" defer></script>
@endsection