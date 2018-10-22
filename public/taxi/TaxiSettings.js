$(document).ready(function(){

    $('.delete_locations').click(function(){
        $(this).parent().parent().parent().remove();
    });

    $('#add_airport_locations').click(function(){

        if($('#airport_location_name').val != ''){

            var airport_location_add = '<div class="widget-box widget-color-orange collapsed ui-sortable-handle" id="widget-box-3"><div class="widget-header widget-header-small"><h6 class="widget-title airport_titles">'+$('#airport_location_name').val()+'</h6><div class="widget-toolbar"><a href="#" data-action="close"><i class="ace-icon fa fa-times"></i></a></div></div></div>';
            
            $('.airport_locations_list').append(airport_location_add);

            $('#airport_location_name').val('');

        }


    });
  
});