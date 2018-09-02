$(document).ready(function () {

    //Clearing all the input fields
    $('.form-inline [type="text"]').each(function(){
        $(this).val('');
    });

    //Add Item functionality
    $('#add_item').click(function(){
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'add_item',
                code: $('#code').val(),
                name: $('#name').val(),
                costpu: $('#costpu').val(),
                threshold: $('#threshold').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success) {
                        location.reload();
                }
            }
        });
    });

    //Edit Item functionality
    $('.edit-btn').click(function(){
        var id = $(this).parent().parent().parent().parent().attr('data-id');

        //Disable clicking again
        $('.edit-btn').off('click');

        //Showing the Done icon
        $(this).parent().parent().children('.done-btn').fadeIn();

        //Converting all the TDs to Input type
        $(this).parent().parent().parent().parent().children('.input-edit').each(function(){
            var current_value = $(this).text();
            var current_type = $(this).attr('data-type');
            $(this).empty();
            $(this).html('<input id="'+current_type+'" value="'+current_value+'" type="text" class="input-small">');
        });

            //AJAX call to update values
            $('.done-btn').click(function(){
                $.ajax({
                    type: 'post',
                    url: $('#url_ajax').val(),
                    data: {
                        function_name: 'update_item',
                        id: id,
                        code: $('#code_edit').val(),
                        name: $('#name_edit').val(),
                        costpu: $('#costpu_edit').val(),
                        available: $('#available_edit').val(),
                        threshold: $('#threshold_edit').val(),
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

    $('.remove-btn').click(function(){
        var id = $(this).parent().parent().parent().parent().attr('data-id');
        $('#confirm_delete_modal').modal();

        $('#confirm_delete').click(function(){
            $.ajax({
                type: 'post',
                url: $('#url_ajax').val(),
                data: {
                    function_name: 'delete_item',
                    id: id,
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

    $('#reset').click(function(){
        $('.form-inline [type="text"]').each(function(){
                $(this).val('');
        });
    });

  

});
