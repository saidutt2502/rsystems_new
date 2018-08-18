$(document).ready(function () {


    //All chosen initialization
    $(".chosen-select").each(function(){
        $(".chosen-select").chosen({width: "100%"});
        if($(this).val($(this).attr('data-hod')) !== 'NULL'){
            $(this).val($(this).attr('data-hod'));
            $(this).trigger("chosen:updated");
        }

    });

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
        }
    });

 });
});
