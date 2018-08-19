$(document).ready(function () {

    //Setting Menu items to active
    $('li').removeClass('active');
    $('#step2-menu-nav').addClass('active');
    $('#inception-nav-menu').css("display","block");
    $('#inception-nav-menu').removeClass('nav-hide');
    $('#inception-nav-menu').addClass('nav-show');

    var availableTags = [];

    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'get_list_user',
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
           for(var i=0;i<data.length;i++){
               availableTags.push(data[i]['emp_id']);
           }
        }
    });

    $( "#emp_id" ).autocomplete({
        source: availableTags
    });

    $("#emp_id").change(function(){
        emp_id=$(this).val();
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'autocomplete_user',
                emp_id: emp_id,
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                $('#name').val(data[0].name);
                $('#email').val(data[0].email);
                $('#password').val('*********');

                $('#emp_id').prop('disabled', true);
                $('#name').prop('disabled', true);
                $('#email').prop('disabled', true);
                $('#password').prop('disabled', true);
                
               
            }
        });
    });

    $('#add_user').click(function(){
                $.ajax({
                    type: 'post',
                    url: $('#url_ajax').val(),
                    data: {
                        function_name: 'add_user',
                        email: $('#email').val(),
                        password: $('#password').val(),
                        emp_id: $('#emp_id').val(),
                        name: $('#name').val(),
                        loc_id: $('#location_id').val(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        if (data.success) {
                                location.reload();
                        }
                    }
                });
    });

    $('#reset').click(function(){
        
       //Emptying the Input types
            $('#email').val('');
            $('#password').val('');
            $('#emp_id').val('');
            $('#name').val('');

            $('#emp_id').prop('disabled', false);
            $('#name').prop('disabled', false);
            $('#email').prop('disabled', false);
            $('#password').prop('disabled', false);
    });


    $('.remove-user').click(function(){
        var user_id = $(this).attr('data-userid');
        $('#confirm_delete_modal').modal();

        $('#confirm_delete').click(function(){
            $.ajax({
                type: 'post',
                url: $('#url_ajax').val(),
                data: {
                    function_name: 'delete_user',
                    user_id: user_id,
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

});
