$(document).ready(function () {

    $('#add_user').click(function(){

        var is_validated = validate_values();
        if(is_validated == 1 ){
            var error_details = 0;
            $.ajax({
                    type: 'post',
                    url: $('#url_ajax').val(),
                    data: {
                        function_name: 'check_user_details',
                        email: $('#email').val(),
                        emp_id: $('#emp_id').val(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        if (data.success == 'false'){
                            $('#error_msg').text(data.msg);
                            $('#error_modal').modal('open');
                            error_details = 1;
                        }
                    }
                });

            if(error_details == 0){
                //Ajax Call to List  the current Users
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
                            $('#user_list_table').append('<tr id='+data.insert_id+'><td>'+ $('#emp_id').val()+'</td><td>'+ $('#name').val()+'</td><td>'+$('#email').val()+'</td><td><i data-userid='+data.insert_id+' class="material-icons remove-user">close</i></td></tr>');
                        
                            //Emptying the Input types
                                $('#email').val('');
                                $('#password').val('');
                                $('#emp_id').val('');
                                $('#name').val('');

                                $('.remove-user').click(function(){
                                    var user_id = $(this).attr('data-userid');
                                    $('#confirm_modal').modal('open');
                            
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
                                                      $('#'+user_id).fadeOut();
                                                }
                                            }
                                        });
                                    });
                                });
                        }
                    }
                });
            }
        }

    });

    $('#reset').click(function(){
        
       //Emptying the Input types
            $('#email').val('');
            $('#password').val('');
            $('#emp_id').val('');
            $('#name').val('');
    });


    $('.remove-user').click(function(){
        var user_id = $(this).attr('data-userid');
        $('#confirm_modal').modal('open');

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
                          $('#'+user_id).fadeOut();
                    }
                }
            });
        });
    });

});

function validate_values(){

    var email =  $('#email').val(),
    password =  $('#password').val(),
    emp_id =  $('#emp_id').val(),
    name =  $('#name').val(),
    validate = 1;

    
    if(password == ''){
        $('#error_msg').text('Please Enter Password');
        $('#error_modal').modal('open');
        validate = 0;
    }else{
        if(password.length < 6){
            $('#error_msg').text('Password Minimum 6 Characters');
            $('#error_modal').modal('open');
            validate = 0;
        }
    }


    if(email == ''){
        $('#error_msg').text('Please Enter Email Address');
        $('#error_modal').modal('open');
        validate = 0;
    }


    if(emp_id == ''){
        $('#error_msg').text('Please Enter Employee ID');
        $('#error_modal').modal('open');
        validate = 0;
    }

    if(name == ''){
        $('#error_msg').text('Please Enter Employee Name');
        $('#error_modal').modal('open');
        validate = 0;
    }

    return validate;
}