$(document).ready(function(){

    //Set Department DropDown
            $.ajax({
                type: 'post',
                url: "/tms_ajax",
                data: {
                    function_name: 'get_dept_session',
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                     $("#select_dept").val(parseInt(data)).trigger("chosen:updated");
                }
            });
   
    $('#taxi').click(function(){
        window.location.href="taxi-request-form"; 
        });
    $('#stationary').click(function(){
            window.location.href="item-request"; 
            });
    $('#gatepass').click(function(){
            window.location.href="gp-request"; 
                });
                
    $('#safety').click(function(){
        window.location.href="shoes-request";
                        });   

     $("#select_dept").chosen().change(function(event){
        $.ajax({
            type: 'post',
            url: "/tms_ajax",
            data: {
                function_name: 'set_dept_session',
                dept_id: $('#select_dept').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
            }
        });
    });
        

});    