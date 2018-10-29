@extends('layouts.user-master')

@section('css-files')
<link rel="stylesheet" href="{{ asset('/taxi/module_style.css') }}" />
@endsection

@section('breadcrumb')
    <li class="active">Taxi Settings</li>
@endsection


@section('main-content')
<div id="fuelux-wizard-container">
    <div>
        <ul class="steps">
            <li data-step="1" class="active">
                <span class="step">1</span>
                <span class="title">Base Settings</span>
            </li>

            <li data-step="2">
                <span class="step">2</span>
                <span class="title">Airport Locations Settings</span>
            </li>
        </ul>
    </div>

    <hr />

    <div class="step-content pos-rel">
        <div class="step-pane active" data-step="1">
            <form class="form-horizontal">
                    <div class="form-group">
                        <label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right">Base Kilometers</label>
                        @if($taxisettings)
                        <div class="col-xs-12 col-sm-5">
                            <span class="block input-icon input-icon-right">
                                <input type="text" value="{{$taxisettings->base_kms}}" id="basekms" class="width-100" />
                            </span>
                        </div>
                        @else
                        <div class="col-xs-12 col-sm-5">
                            <span class="block input-icon input-icon-right">
                                <input type="text" id="basekms" class="width-100" />
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="inputError" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right">Day Charges Start at</label>
                        @if($taxisettings)
                        <div class="col-xs-12 col-sm-5">
                            <span class="block input-icon input-icon-right">
                                <input type="time"  value="{{$taxisettings->day_time}}" id="dayTime" class="width-100" />
                            </span>
                        </div>
                        @else
                        <div class="col-xs-12 col-sm-5">
                            <span class="block input-icon input-icon-right">
                                <input type="time" id="dayTime" class="width-100" />
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="inputError" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right">Night Charges Start at</label>
                        @if($taxisettings)
                        <div class="col-xs-12 col-sm-5">
                            <span class="block input-icon input-icon-right">
                                <input type="time"  value="{{$taxisettings->night_time}}" id="nightTime" class="width-100" />
                            </span>
                        </div>
                        @else
                        <div class="col-xs-12 col-sm-5">
                            <span class="block input-icon input-icon-right">
                                <input type="time" id="nightTime" class="width-100" />
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="inputSuccess" class="col-xs-12 col-sm-3 control-label no-padding-right">Mid-Night Charges starts at</label>
                        @if($taxisettings)
                        <div class="col-xs-12 col-sm-5">
                            <span class="block input-icon input-icon-right">
                                <input type="time" value="{{$taxisettings->midnight_time}}" id="midnightTime" class="width-100" />
                            </span>
                        </div>
                        @else
                        <div class="col-xs-12 col-sm-5">
                            <span class="block input-icon input-icon-right">
                                <input type="time"  id="midnightTime" class="width-100" />
                            </span>
                        </div>
                        @endif
                    </div>
                </form>
        </div>

        <div class="step-pane" data-step="2">
        <div>
        <div class="form-group">

            <div class="col-xs-12 col-sm-5 col-sm-offset-3">
                <span class="block input-icon input-icon-right">
                    <input id="airport_location_name" class="width-100" type="text">
                    <i id="add_airport_locations" class="ace-icon fa fa-gavel"></i>
                </span>
            </div>
            <div class="help-block col-xs-12 col-sm-reset inline">&nbsp;</div>
        </div>

        <div class="col-xs-12 col-sm-9 widget-container-col col-sm-offset-1" id="widget-container-col-1">
                <div class="widget-box" id="widget-box-1">
                    <div class="widget-header">
                        <h5 class="widget-title">Added Locations</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main airport_locations_list">
                        <!-- foreach begins here -->
                        @if($taxisettings)
                        @foreach(explode(',', $taxisettings->airport_locations) as $each_location)
                        @if($each_location != '')
                        <div class="widget-box widget-color-orange collapsed ui-sortable-handle " id="widget-box-3">
                            <div class="widget-header widget-header-small">
                                <h6 class="widget-title airport_titles">
                                    {{$each_location}}
                                </h6>

                                <div class="widget-toolbar">
                                    <a class="delete_locations">
                                        <i class="ace-icon fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            </div>
                                @endif
                            @endforeach
                            @endif
                            <!-- foreach ends here -->
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<hr />
<div class="wizard-actions">
    <button class="btn btn-prev">
        <i class="ace-icon fa fa-arrow-left"></i> Prev
    </button>

    <button class="btn btn-success btn-next" data-last="Finish">
        Next
        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
    </button>
</div>
</div>

<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('taxi-ajax')}}" id="url_ajax">

		<!--[if !IE]> -->
		<script src="/core/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='/core/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="/core/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->
		<script src="/core/js/wizard.min.js"></script>
		<script src="/core/js/jquery.validate.min.js"></script>
		<script src="/core/js/jquery-additional-methods.min.js"></script>
		<script src="/core/js/bootbox.js"></script>
		<script src="/core/js/jquery.maskedinput.min.js"></script>
		<script src="/core/js/select2.min.js"></script>

		<!-- ace scripts -->
		<script src="/core/js/ace-elements.min.js"></script>
		<script src="/core/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->

            <!-- Custom File -->
            <script src="{{ asset('/taxi/TaxiSettings.js') }}" defer></script>


		<script type="text/javascript">
			jQuery(function($) {
			
				$('[data-rel=tooltip]').tooltip();
			
				$('.select2').css('width','200px').select2({allowClear:true})
				.on('change', function(){
					$(this).closest('form').validate().element($(this));
				}); 
			
			
				var $validation = false;
				$('#fuelux-wizard-container')
				.ace_wizard({
					//step: 2 //optional argument. wizard will jump to step "2" at first
					//buttons: '.wizard-actions:eq(0)'
				})
				.on('actionclicked.fu.wizard' , function(e, info){
					if(info.step == 1 && $validation) {
						if(!$('#validation-form').valid()) e.preventDefault();
					}
				})
				//.on('changed.fu.wizard', function() {
				//})
				.on('finished.fu.wizard', function(e) {
					bootbox.dialog({
						message: "Thank you! Your information was successfully saved!", 
						buttons: {
							"success" : {
								"label" : "OK",
								"className" : "btn-sm btn-primary"
							}
						}
                    });
                    
/* --------------------- AJAX CALL TO save values to DB ---------------------------------------- */

var airport_L_array = '';

$('.airport_titles').each(function (index, value) { 
    airport_L_array += $(this).text()+',';
});

      $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'edit_taxi_details',
            basekms: $('#basekms').val(),
            nightTime: $('#nightTime').val(),
            midnightTime: $('#midnightTime').val(),
            dayTime: $('#dayTime').val(),
            airportLocations: airport_L_array,
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            $(this).parent().parent().find('.mod_name').val('');
                location.reload();
        }
    }); 


/*-------------------------------AJAX CALL Ends  ----------------------------------------------- */




				}).on('stepclick.fu.wizard', function(e){
					//e.preventDefault();//this will prevent clicking and selecting steps
				});
				
				$('#modal-wizard-container').ace_wizard();
				$('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');
				
				$(document).one('ajaxloadstart.page', function(e) {
					//in ajax mode, remove remaining elements before leaving page
					$('[class*=select2]').remove();
				});
			})
		</script>
@endsection