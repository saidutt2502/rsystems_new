$(document).ready(function () {

  $('select').formSelect();

  $('.add_hod').on("change",function(){
       
    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'assign_hod',
            user_id: $(this).val(),
            dept_id: $(this).attr('dept-id'),
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
           location.reload();
        }
    });

 });

 $('.delete_hod').click(function(){
    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'delete_hod',
            user_id: $(this).attr('user-id'),
            dept_id: $(this).attr('dept-id'),
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
           location.reload();
        }
    });
 });

});
