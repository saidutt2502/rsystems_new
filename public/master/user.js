$(document).ready(function(){

    //Set Department DropDown
            // $.ajax({
            //     type: 'post',
            //     url: "/tms_ajax",
            //     data: {
            //         function_name: 'get_dept_session',
            //         '_token': $('input[name=_token]').val()
            //     },
            //     success: function (data) {
            //          $("#select_dept").val(parseInt(data)).trigger("chosen:updated");
            //     }
            // });
   
    $('#taxi').click(function(){
        window.location.href="taxi-request-form"; 
        });
    $('#stationary').click(function(){
            window.location.href="item-request"; 
            });
    $('#gatepass').click(function(){
            window.location.href="gp-request"; 
                });
                
    $('#issues').click(function(){
        window.location.href="issue-request-form";
                        });
                    

    $('#dept').click(function(){
        $('#myModal_selectdept').modal();
        return false;
    });  
    
    $('#confirm_proceed').click(function(){
    $.ajax({
        type: 'post',
        url: "/tms_ajax",
        data: {
            function_name: 'set_dept_session',
            dept_id: $('#select_dept').val(),
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            window.location.href="tms_tools";
        }
    });
});    

});    