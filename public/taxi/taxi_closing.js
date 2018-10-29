$(document).ready(function(){

    $('.show-details-btn').on('click', function(e) {
        e.preventDefault();
        $(this).closest('tr').next().toggleClass('open');
        $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
    });

    $('.start-btn').click(function(){
        var dt = new Date();
           var hours = ('0'+dt.getHours()).slice(-2);
           var mins = ('0'+dt.getMinutes()).slice(-2);
           var time = hours+ ":" + mins;

           

        $('#schedule_id').val($(this).attr('data-uniqueID'));
        $('#time').val(time);
        $('#myModal').modal();
    });

    $('#confirm_start').click(function(){
        if($('#date').val()==''||$('#time').val()==''||$('#start_kms').val()=='')
        {
            alert("Please Enter All Fields!");
        }
        else
        {
            $.ajax({
                type: 'post',
                url: $('#url_ajax').val(),
                data: {
                    function_name: 'start_trip',
                    schedule_id: $('#schedule_id').val(),
                    start_date: $('#date').val(),
                    start_time: $('#time').val(),
                    start_kms: $('#start_kms').val(),
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                    location.reload();
                }
            });
        }
    });

    $('.close-btn').click(function(){
        var dt = new Date();
           var hours = ('0'+dt.getHours()).slice(-2);
           var mins = ('0'+dt.getMinutes()).slice(-2);
           var time = hours+ ":" + mins;

           

        $('#schedule_id_close').val($(this).attr('data-uniqueID'));
        $('#time_close').val(time);
        $('#myModal_close').modal();
    });

    $('#confirm_close').click(function(){
        if($('#date_close').val()==''||$('#time_close').val()==''||$('#close_kms').val()==''||$('#extra_costs').val()==''||$('#wait_time').val()=='')
        {
            alert("Please Enter All Fields!");
        }
        else
        {
            $.ajax({
                type: 'post',
                url: $('#url_ajax').val(),
                data: {
                    function_name: 'close_trip',
                    schedule_id: $('#schedule_id_close').val(),
                    close_date: $('#date_close').val(),
                    close_time: $('#time_close').val(),
                    close_kms: $('#close_kms').val(),
                    extra_costs: $('#extra_costs').val(),
                    wait_time: $('#wait_time').val(),
                    remarks: $('#remarks').val(),
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                    location.reload();
                    
                }
            });
        }
    });
});    