$(document).ready(function(){

    
    
    $(".chosen-select").each(function(){
        $(".chosen-select").chosen({width: "100%"}); 
    });


    $('select').formSelect();
    $('.modal').modal();

    $('#oc_details').click(function(){
        $('#modal1').modal('open');
    });

    $('#submit').click(function(){
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
                $('.chosen-select').val("");
                $('.chosen-select').trigger("chosen:updated");
                $('#levels').val('');
            }
        });
    });

  });