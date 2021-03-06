$(document).ready(function () {

    //Setting Menu items to active
    $('li').removeClass('active');
    $('#gp_request_li_to_be').addClass('active');
    $('#item-nav-menu_gp').css("display","block");
    $('#item-nav-menu_gp').removeClass('nav-hide');
    $('#item-nav-menu_gp').addClass('nav-show');

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

    

    if($('#date').val()==''||$('#shift').val()==null||$('#purpose').val()==null||$('#reason').val()==''||$('#return').val()==null||$('#from').val()==''||($('#return').val()=='Yes' && $('#to').val()==''))
    {
        alert('Please Enter All Fields!');
    }
    else
    {
        if($('#purpose').val()=='Personal Work'||$('#purpose').val()=='Early Out')
    {
            $.ajax({
                type: 'post',
                url: $('#url_ajax').val(),
                data: {
                    function_name: 'check_difference',
                    shift_id: $('#shift').val(),
                    from:$('#from').val(),
                    to: $('#to').val(),
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) 
                {
                    
                    if(data.value>data.limit)
                    {
                        alert('LIMIT EXCEEDED,CANNOT SUBMIT GATEPASS!\n\nNumber of Hours Requested: '+data.value/60+'\nLimit: '+data.limit/60+'\n\nApply for Leave');
                    }
                    else
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
                                requested_time:data.value,
                                '_token': $('input[name=_token]').val()
                            },
                            success: function (data) 
                            {
                                
                                if (data.success)
                                {
                                    if(data.total>data.limit)
                                   {
                                         alert('LIMIT EXCEEDED,CANNOT SUBMIT GATEPASS!\n\nNumber of Hours of Abscence(With Requested Time): '+data.total+'\nLimit: '+data.limit+'\n\nApply for Leave');
                   
                                    }
                                else
                               {   
                                    $('#submit').off('click');
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
                }   
            });
     
    }
    else
    {
        $('#submit').off('click');
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
   
});
});