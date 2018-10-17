$(document).ready(function () {

    
    $('#return').change(function(){
    $(".timing").remove();
    if($('#return').val()=='No')
    {
      $('#add_time').append('<div class="form-group timing"><label class="col-sm-3 control-label no-padding-right">Time</label><div class="col-sm-9"><input id="from" class="col-xs-10 col-sm-5" type="time" required></div></div>');
    }
    else
    {
      $('#add_time').append('<div class="form-group timing"><label class="col-sm-3 control-label no-padding-right">Time (Out)</label><div class="col-sm-9"><input id="from" class="col-xs-10 col-sm-5" type="time" required></div></div><div class="form-group timing"><label class="col-sm-3 control-label no-padding-right">Time (In)</label><div class="col-sm-9"><input id="to" class="col-xs-10 col-sm-5" type="time" required></div></div>');   
    }
        $('#reset').click(function()
        {
           $(".timing").remove();
        });
    
});

$('#submit').click(function(){

    
        

    if($('#purpose').val()=='Personal Work'||$('#purpose').val()=='Early Out'||$('#purpose').val()=='Late Coming')
    {
        var date = $('#date').val()
        var year = date.substring(0, 4);
        var month = date.substring(5, 7);

        $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'calculate_total',
            user_id: $('#user_id').val(),
            year: year,
            month: month,
            '_token': $('input[name=_token]').val()
        },
        success: function (data) 
        {
            if (data.success)
            {
                if(data.total>=data.limit)
                {
                    alert('LIMIT EXCEEDED,CANNOT SUBMIT GATEPASS!\n\nNumber of Hours of Abscence: '+data.total+'\nLimit: '+data.limit+'\n\nApply for Leave');
                  
                }
                else
                {
                    
                        $.ajax({
                            type: 'post',
                            url: $('#url_ajax').val(),
                            data: {
                                function_name: 'add_entry',
                                user_id: $('#user_id').val(),
                                date: $('#date').val(),
                                shift: $('#shift').val(),
                                purpose: $('#purpose').val(),
                                reason: $('#reason').val(),
                                from: $('#from').val(),
                                to: $('#to').val(),
                                '_token': $('input[name=_token]').val()
                            },
                            success: function (data) 
                            {
                                if (data.success)
                                {
                                    window.location.href="my-request_gp"; 
                                }
                            }   
                        });
                          
                }  
            }
        }
    });
    }
    else
    {
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'add_entry',
                user_id: $('#user_id').val(),
                date: $('#date').val(),
                shift: $('#shift').val(),
                purpose: $('#purpose').val(),
                reason: $('#reason').val(),
                from: $('#from').val(),
                to: $('#to').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) 
            {
                if (data.success)
                {
                    window.location.href="my-request_gp"; 
                }
            }   
        });
    }
    

});
});