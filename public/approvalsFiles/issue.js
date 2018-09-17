$(document).ready(function () {
    $('#home_tab_first').addClass('active');


    $('.issue-btn').click(function(){
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'issue_request',
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