$(document).ready(function(){


    //Pre populate the fields
    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'find_type',
            vendor: $('#vendor_car').val(),
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            for(var i=0;i<data.count;i++)
            {
            $('#type_car').append('<option class="to_clear" value="'+data[i]['id']+'">'+data[i]['type']+'</option>');

            var append= '<div class="widget-box widget-color-orange collapsed ui-sortable-handle">            <div class="widget-header widget-header-small"><h6 class="widget-title airport_titles">'+ data[i]['type']+'</h6><div class="widget-toolbar"><a data-action="close" class="delete_list" data-table="rs_taxi_type" data-id="'+data[i]['id']+'"><i class="ace-icon fa fa-times"></i></a></div></div></div>';

            $('#taxi_list_modal').append(append);
            }
            $("#type_car").trigger("chosen:updated"); 

            $('.delete_list').click(function(){
                var table = $(this).attr('data-table');
                var id = $(this).attr('data-id');
            
                $.ajax({
                    type: 'post',
                    url: $('#url_ajax').val(),
                    data: {
                        table: table,
                        id: id,
                        function_name: 'delete_taxi_list',
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        location.reload();
                    }
                });
            
            });
           
        }
    });

    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'find_taxi_number',
            vendor: $('#vendor_car').val(),
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            for(var i=0;i<data.count;i++)
            {
                var append= '<div class="widget-box widget-color-orange collapsed ui-sortable-handle">            <div class="widget-header widget-header-small"><h6 class="widget-title airport_titles">'+ data[i]['taxino']+'</h6><div class="widget-toolbar"><a data-action="close" class="delete_list" data-table="rs_taxi_cars" data-id="'+data[i]['id']+'"><i class="ace-icon fa fa-times"></i></a></div></div></div>';

                $('#number_taxi_list').append(append);
            }
        }
    });



    //Ends here
$('#add_vendor').click(function(){
    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'add_vendor',
            vendor_name: $('#vendor_name').val(),
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            location.reload();
        }
    });
});



$('.delete_list').click(function(){
    var table = $(this).attr('data-table');
    var id = $(this).attr('data-id');

    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            table: table,
            id: id,
            function_name: 'delete_taxi_list',
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            location.reload();
        }
    });

});

$('#submit').click(function(){

    var airport_location = new Array();
    var airport_charge = new Array();
    $(".airport_details_input").each(function(){
            airport_location.push($(this).attr('data-place'));
            airport_charge.push($(this).val());
    });

    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'add_type',
            vendor: $('#vendor').val(),
            type: $('#type').val(),
            base_kms: $('#base_kms').val(),
            per_km: $('#per_km').val(),
            night: $('#night').val(),
            midnight: $('#midnight').val(),
            wait: $('#wait').val(),
            airport_locations: airport_location,
            airport_charges: airport_charge,
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            location.reload();
        }
    });
});

$('#reset').click(function(){

    $('#vendor').val('');
    $('#type').val('');
    $('#base_kms').val('');
    $('#per_km').val('');
    $('#night').val('');
    $('#midnight').val('');
    $('#wait').val('');
});

$('.vendor_dd').change(function(){
    $('.to_clear').remove();
    $('#taxi_list_modal').children().remove();
    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'find_type',
            vendor: $('#vendor_car').val(),
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            for(var i=0;i<data.count;i++)
            {
            $('#type_car').append('<option class="to_clear" value="'+data[i]['id']+'">'+data[i]['type']+'</option>');

            var append= '<div class="widget-box widget-color-orange collapsed ui-sortable-handle">            <div class="widget-header widget-header-small"><h6 class="widget-title airport_titles">'+ data[i]['type']+'</h6><div class="widget-toolbar"><a data-action="close" class="delete_list" data-table="rs_taxi_type" data-id="'+data[i]['id']+'"><i class="ace-icon fa fa-times"></i></a></div></div></div>';

            $('#taxi_list_modal').append(append);
                update_taxi_number_list();
            }
            $("#type_car").trigger("chosen:updated"); 

            $('.delete_list').click(function(){
                var table = $(this).attr('data-table');
                var id = $(this).attr('data-id');
            
                $.ajax({
                    type: 'post',
                    url: $('#url_ajax').val(),
                    data: {
                        table: table,
                        id: id,
                        function_name: 'delete_taxi_list',
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        location.reload();
                    }
                });
            
            });
           
        }
    });
});
$('#submit_car').click(function(){

    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'add_car',
            vendor: $('#vendor_car').val(),
            type: $('#type_car').val(),
            taxino: $('#taxino').val(),
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            location.reload();
        }
    });
});

$('#reset_car').click(function(){
    $('#taxino').val('');
});

function update_taxi_number_list(){

    $('#number_taxi_list').children().remove();
    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'find_taxi_number',
            vendor: $('#vendor_car').val(),
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            for(var i=0;i<data.count;i++)
            {
                var append= '<div class="widget-box widget-color-orange collapsed ui-sortable-handle">            <div class="widget-header widget-header-small"><h6 class="widget-title airport_titles">'+ data[i]['taxino']+'</h6><div class="widget-toolbar"><a data-action="close" class="delete_list" data-table="rs_taxi_cars" data-id="'+data[i]['id']+'"><i class="ace-icon fa fa-times"></i></a></div></div></div>';

                $('#number_taxi_list').append(append);
            }
        }
    });
}

});