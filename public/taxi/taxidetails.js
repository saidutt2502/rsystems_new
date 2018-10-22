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

});