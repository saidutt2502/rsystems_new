$(document).ready(function () {
    $('#home_tab_first').addClass('active');


    $('.approve-btn').click(function(){
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'approve_request',
                id: $(this).attr('data-uniqueID'),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success) {
                        location.reload();
                }
            }
        });
    });

    $('.reject-btn').click(function(){
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'decline_request',
                id: $(this).attr('data-uniqueID'),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success) {
                        location.reload();
                }
            }
        });
    });
});