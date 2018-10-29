$(document).ready(function(){
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

$('#vendor_car').change(function(){
    $('.to_clear').remove();
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
            }
            $("#type_car").trigger("chosen:updated"); 
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

});