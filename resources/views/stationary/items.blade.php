@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Stationary</li>
@endsection


@section('page-header')
    <h1>Stationary
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Stock</small>
    </h1>
@endsection

@section('main-content')
    <div class="widget-box hidden-480">
            <div class="widget-header">
                <h4 class="widget-title">Add Items</h4>
                <button type="button" id="update_item" class="btn btn-default btn pull-right">
                            <i class="ace-icon fa fa-stop bigger-110"></i>Update Stock
                </button>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-inline">
                        <span class="input-icon">
                            <input id="code" placeholder="Item Code" type="text">
                            <i class="ace-icon fa fa-key blue"></i>
                        </span>
                        <span class="input-icon">
                            <input id="name" placeholder="Name" type="text">
                            <i class="ace-icon fa fa-users blue"></i>
                        </span>
                        <span class="input-icon">
                            <input id="costpu" placeholder="Cost/Unit" type="text">
                            <i class="ace-icon fa  fa-eye  red"></i>
                        </span>
                        <span class="input-icon">
                            <input id="threshold" placeholder="Threshold" type="text">
                            <i class="ace-icon fa  fa-eye  red"></i>
                        </span>
                        <button type="button" id="add_item" class="btn btn-info btn-sm">
                            <i class="ace-icon fa fa-check bigger-110"></i>Add
                        </button>
                        <button type="button" id="reset" class="btn btn-danger btn-sm">
                            <i class="ace-icon fa fa-stop bigger-110"></i>Reset
                        </button>
                    </form>
                </div>
            </div>
    </div>
    <br>
    <div class="clearfix">
            <div class="pull-right tableTools-container"></div>
        </div>
        <div>
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Item Code</th>
                        <th>Name</th>
                        <th>Available</th>
                        <th class="hidden-480">Cost/Unit</th>
                        <th class="hidden-480">Threshold</th>
                        <th class="hidden-480">
                            <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                            Updated
                        </th>
                        <th class="hidden-480"></th>
                    </tr>
                </thead>

                <tbody>
                    @if($item)
                        @foreach($item as $each_item)
                    <tr data-id="{{$each_item->id}}" >
                        <td data-type="code_edit" class="input-edit">{{$each_item->code}}</td>
                        <td data-type="name_edit" class="input-edit">{{$each_item->name}}</td>
                        <td data-type="available_edit" class="input-edit">{{$each_item->available}}</td>
                        <td data-type="costpu_edit" class="input-edit hidden-480">{{$each_item->costpu}}</td>
                        <td data-type="threshold_edit" class="input-edit hidden-480">{{$each_item->threshold}}</td>
                        <td class="hidden-480">@if($each_item->updated_at){{ date("D, d F Y",strtotime($each_item->updated_at))}}@endif</td>
                        <!-- data-type="available_edit" class="input-edit" -->

                        <td class="hidden-480">
                            <div class="hidden-sm hidden-xs action-buttons">
                                <a class="info" href="javascript:void(0)">
                                    <i class="ace-icon fa fa-pencil bigger-130 edit-btn"></i>
                                </a>

                                <a class="green done-btn" href="javascript:void(0)" style="display:none">
                                    <i class="ace-icon fa fa-check bigger-130"></i>
                                </a>

                                <a class="red" href="javascript:void(0)">
                                    <i class="ace-icon fa fa-trash-o bigger-130 remove-btn"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>

        
<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('stationary_ajax')}}" id="url_ajax">

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

    <!-- Update items Modal -->
    <div id="update_item_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Item</h4>
      </div>
      <div class="modal-body">
      <div class="form-group clone-this">
          <div>
            <div class="col-sm-12">
                <div class="col-sm-5">
                    <select name="item_id[]" id="first_chosen_list" class="chosen-container chosen-container-single chosen-select item_id">
                        <option value="" disabled selected>Select Item</option>
                            @foreach($item as $each_item)
                            <option class="item_options" value="{{$each_item->id}}">{{$each_item->name}}</option>
                            @endforeach
                    </select>
                </div>
                <div class="col-sm-5">
                <span class="input-icon">
                            <input placeholder="Quantity" class="updated_qty" name="qty[]" type="text">
                            <i class="ace-icon fa fa-envelope blue"></i>
                    </span>
                </div>
                <div class="col-sm-1 col-md-1">
                    <button type="button" class="btn btn-warning  btn-xs btn-clone">
                        <i class="ace-icon fa fa-plus bigger-110 icon-only"></i>
                    </button>
                </div>
            </div>
        </div>
</div>
                <br><br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="confirm_update">Update</button>
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