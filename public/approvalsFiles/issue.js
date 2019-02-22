$(document).ready(function () {
    $('#home_tab_first').addClass('active');


    $('.issue-btn').click(function(){
        $('.issue-btn').off('click');
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'issue_request',
                id: $(this).attr('data-uniqueID'),
                item_id: $(this).attr('data-item_id'),
                item_qty: $(this).attr('data-item_qty'),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success) {
                        location.reload();
                }
            }
        });
    });

    $('.shoes_issue-btn').click(function(){
        $('.shoes_issue-btn').off('click');
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'shoes_issue_request',
                id: $(this).attr('data-uniqueID'),
                shoes_id: $(this).attr('data-shoes_id'),
                shoes_qty: $(this).attr('data-shoes_qty'),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success) {
                        location.reload();
                }
            }
        });
    });

    $('.hk_issue-btn').click(function(){
        $('.hk_issue-btn').off('click');
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'hk_issue_request',
                id: $(this).attr('data-uniqueID'),
                item_id: $(this).attr('data-hk_id'),
                item_qty: $(this).attr('data-hk_qty'),
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