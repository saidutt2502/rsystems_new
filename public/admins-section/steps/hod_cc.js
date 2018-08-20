$(document).ready(function(){

    $('.show-details-btn').on('click', function(e) {
        e.preventDefault();
        $(this).closest('tr').next().toggleClass('open');
        $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
    });
    var cc_no;

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
              location.reload(); 
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
                location.reload();
               
            }
        });
    });
   
  });

 