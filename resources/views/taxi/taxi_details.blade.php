@extends('layouts.user-master')

@section('css-files')
<link rel="stylesheet" href="{{ asset('/taxi/taxidetails.css') }}" />
@endsection

@section('breadcrumb')
    <li class="active">Taxi Details</li>
@endsection


@section('main-content')
    <b>ADD VENDOR</b><br>
    <div class="form-group">

            <div class="col-xs-12 col-sm-5 col-sm-offset-3">
                <span class="block input-icon input-icon-right">
                    <input id="vendor_name" placeholder="Vendor Name" class="width-100" type="text">
                    <i id="add_vendor" class="ace-icon fa fa-gavel"></i>
                </span>
            </div>
            <div class="help-block col-xs-12 col-sm-reset inline">&nbsp;</div>
            <button class="btn btn-xs" type="button" data-toggle="modal" data-target="#vendor_modal">
                    <i class="ace-icon fa fa-eye bigger-110"></i>
                    Vendor List
                </button>  
    </div>
    <hr />

                                            <!-- TAXI TYPE -->
    <b>TAXI TYPE</b><br><br><button class="btn btn-xs" type="button" data-toggle="modal" data-target="#taxi_type_modal">
                    <i class="ace-icon fa fa-eye bigger-110"></i>
                   Taxi Type
                </button>&nbsp;&nbsp;&nbsp;(Select Vendor to view types)<br><br>
    *All unrelated fields must have the value 0
    <br><br><br>
    <div class="form-group">
    <div class="col-sm-12 col-sm-offset-2">
        <div class="col-sm-4">


        <label>Vendor</label>
        <select id="vendor" class="chosen-container chosen-container-single chosen-select vendor_dd">
                               <option selected disabled>Select Vendor</option>
                               @foreach($vendors as $vendor)
                              <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                              @endforeach
        </select><br>
        </div>

        <div class="col-sm-4">
        <label>Taxi Type</label>
        <input type="text" autocomplete="off" id="type" class="form-control"><br>
        </div>
    </div>
    </div>
   

    <div class="form-group">
    <div class="col-sm-12 col-sm-offset-2">
        <div class="col-sm-4">

        <?php
               $base_kms=DB::table('rs_taxisettings')->where('location_id',session('location'))->first();
        ?>

        <label>Cost per {{$base_kms->base_kms}} Kms</label>
        <input type="text" autocomplete="off" id="base_kms" class="form-control" value="0"><br>
        </div>

        <div class="col-sm-4">
        <label>Cost per Km</label>
        <input type="text" autocomplete="off" id="per_km" class="form-control" value="0"><br>
        </div>
    </div>
    </div>

    <div class="form-group">
    <div class="col-sm-12 col-sm-offset-2">
        <div class="col-sm-3">

        <label>Night Charges</label>
        <input type="text" autocomplete="off" id="night" class="form-control" value="0"><br>
        </div>

        <div class="col-sm-3">
        <label>Midnight Charges</label>
        <input type="text" autocomplete="off" id="midnight" class="form-control" value="0"><br>
        </div>

        <div class="col-sm-2">
        <label>Waiting Charges</label>
        <input type="text" autocomplete="off" id="wait" class="form-control" value="0"><br>
        </div>
    </div>
    </div>

    @if($airports)
    @foreach(explode(',', $airports->airport_locations) as $each_location)
    @if($each_location != '')
    <div class="form-group">
    <div class="col-sm-12 col-sm-offset-2">
        <div class="col-sm-4">

        <label>Place</label>
        <input type="text" autocomplete="off" class="form-control" value="{{$each_location}}" disabled><br>
        </div>

        <div class="col-sm-4">
        <label>Airport Charges</label>
        <input type="text" autocomplete="off" data-place="{{$each_location}}" class="form-control  airport_details_input" value="0"><br>
        </div>
    </div>
    </div>
    @endif
    @endforeach
    @endif
    <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-info" type="button" id="submit">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Submit
                </button>

                &nbsp; &nbsp; &nbsp;
                <button class="btn" type="button" id="reset">
                    <i class="ace-icon fa fa-undo bigger-110"></i>
                    Reset
                </button>   
            
        </div>

                                              <!-- CARS -->
    <div class="row">   
    <div class="col-xs-12"><hr>
    <b>CARS</b><br><br><button class="btn btn-xs" type="button" data-toggle="modal" data-target="#taxi_number_modal">
                    <i class="ace-icon fa fa-eye bigger-110"></i>
                   Cars
                </button>&nbsp;&nbsp;&nbsp;(Select Vendor to view cars)<br><br>
    <div class="form-group">
    <div class="col-sm-12 col-sm-offset-2">
    <div class="col-sm-3">
 

        <label>Vendor</label>
        <select id="vendor_car" class="chosen-container chosen-container-single chosen-select vendor_dd">
                               <option selected disabled>Select Vendor</option>
                               @foreach($vendors as $vendor)
                              <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                              @endforeach
        </select><br>
        </div>

        <div class="col-sm-3">

        <label>Type</label>
        <select id="type_car" class="chosen-container chosen-container-single chosen-select">
                       <option selected disabled>Select Type</option>
        </select><br>
        </div>

        <div class="col-sm-2">
        <label>Taxi No.</label>
        <input type="text" autocomplete="off" id="taxino" class="form-control"><br>
        </div> <br>

    </div>
    </div>

    <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-info" type="button" id="submit_car">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Submit
                </button>

                &nbsp; &nbsp; &nbsp;
                <button class="btn" type="button" id="reset_car">
                    <i class="ace-icon fa fa-undo bigger-110"></i>
                    Reset
                </button>   
            
        </div>


    <hr></div>
</div>

    
    <!-- Modal -->
    <div id="vendor_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <center><h4 class="modal-title">Vendors List</h4></center>
      </div>
      <div class="modal-body">
      @foreach($vendors as $vendor)
            <div class="widget-box widget-color-orange collapsed ui-sortable-handle">
                <div class="widget-header widget-header-small" id="vendor_{{$vendor->id}}">
                    <h6 class="widget-title airport_titles">
                        {{$vendor->name}}
                    </h6>

                    <div class="widget-toolbar">
                        <a data-action="close" class="delete_list" data-table="rs_taxi_vendors" data-id="{{ $vendor->id }}">
                            <i class="ace-icon fa fa-times"></i>
                        </a>
                    </div>
                </div>
         </div>
         @endforeach
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
</div>
    
    


  <!-- Last Div dont delete -->
</div>

            
  

  <!-- taxi_type_modal Modal -->
  <div id="taxi_type_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <center><h4 class="modal-title">Taxi Type List</h4></center>
      </div>
      <div  class="modal-body">
      <table class="table table-striped table-bordered table-hover ">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Base Cost</th>
                    <th>Cost/Km</th>
                    <th>Night Charges</th>
                    <th>Midnight Charges</th>
                    <th>Waiting Charges</th>
                    <th></th>
                </tr>
            </thead>
        <tbody id="taxi_list_modal" >
</tbody>
</table>
    </div>
         <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
</div>
</div>   

  <!-- taxi_number_modal Modal -->
  <div id="taxi_number_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <center><h4 class="modal-title">Taxi Number List</h4></center>
      </div>
      <div id="number_taxi_list" class="modal-body">
          
    </div>
         <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
</div>
</div>   


  <!-- taxi_detail_modal Modal -->
  <div id="taxi_detail_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
      <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Edit Taxi Details</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <label class="inline">
                        <span class="lbl"> Type</span>
                        <input type="text" id="m_type" class="form-control">
                        <input type="hidden" id="m_id" class="form-control">
                    </label>
                    <br>
                    <label class="inline">
                        <span class="lbl"> Base Cost</span>
                        <input type="text" id="m_bcost" class="form-control">
                    </label>
                    <br>
                    <label class="inline">
                        <span class="lbl"> Cost/Kms</span>
                        <input type="text" id="m_ckms" class="form-control">
                    </label>
                    <br>
                    <label class="inline">
                        <span class="lbl">Night Charges</span>
                        <input type="text" id="m_ncharges" class="form-control">
                    </label>
                    <br>
                    <label class="inline">
                        <span class="lbl">MidNight Charges</span>
                        <input type="text" id="m_mncharges" class="form-control">
                    </label>
                    <br>
                    <label class="inline">
                        <span class="lbl">Waiting Charges</span>
                        <input type="text" id="m_wcharges" class="form-control">
                    </label>
                    <br>
                </div>
            </div>
        </div>
        </div>
         <div class="modal-footer">
        <button type="button" id="edit_save_modal" class="btn btn-success" data-dismiss="modal">Submit</button>
      </div>
    </div>
</div>
</div>   




<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('taxi-ajax')}}" id="url_ajax">
@endsection

@section('js-files')
        <script src="{{ asset('taxi/taxidetails.js') }}" defer></script>

@endsection