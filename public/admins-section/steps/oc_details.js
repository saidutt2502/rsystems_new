$(document).ready(function(){

    $('.nav-tabs a:first').tab('show') 

    $('.edit-modal').click(function(){
        $('#dept').val($(this).attr('dept-id'));
        $('#myModal').modal();
    });

    $('#confirm_delete').click(function(){
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'store_levels',
                dept_id: $('#dept').val(),
                levels: $('#levels').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                location.reload();
            }
        });
    });

  });