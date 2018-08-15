$(document).ready(function(){
    $('.collapsible').collapsible();
    var cc_no;

    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'get_list_cc',
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            var cc_list = {};
            for (var i = 0; i < data.length; i++) {
              cc_list[data[i].number] = null; //countryArray[i].flag or null
            }
            
            $('.cc_no').autocomplete({
                data: cc_list,
                limit: 5, // The max amount of results that can be shown at once. Default: Infinity.
              });
           
        }
    });

    $('.cc_no').on("change",function(){
        cc_no = $(this).val();
     });
    $(".add_cc").click(function () {
        var dept = $(this).attr('dept-id')
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'add_cc',
                number: cc_no,
                dept_id: dept ,
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
              
                $('#cc_list_table_'+dept).append('<tr id='+data.added_id+'><td>'+cc_no+'</td><td><i cc-id='+data.added_id+' class="material-icons remove-cc">close</i></td></tr>');
                $(".cc_no").val('');

                $(".remove-cc").click(function () {
                    var cc_id=$(this).attr('cc-id');
                    $.ajax({
                        type: 'post',
                        url: $('#url_ajax').val(),
                        data: {
                            function_name: 'delete_cc',
                            cc_id:  cc_id ,
                            '_token': $('input[name=_token]').val()
                        },
                        success: function (data) {
                            $('#'+cc_id).fadeOut();
                           
                        }
                    });
                });
               
            }
        });
    });

    $(".remove-cc").click(function () {
       var cc_id=$(this).attr('cc-id');
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'delete_cc',
                cc_id:  cc_id ,
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success) {
                    $('#'+cc_id).fadeOut();
              }
               
            }
        });
    });
   
  });

 