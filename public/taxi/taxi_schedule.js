$(document).ready(function(){
    $('#home_tab_first').addClass('active');


    $('.show-details-btn').on('click', function(e) {
        e.preventDefault();
        $(this).closest('tr').next().toggleClass('open');
        $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
    });

    $('.assign-btn').click(function(){
        var dt = new Date();
           var hours = ('0'+dt.getHours()).slice(-2);
           var mins = ('0'+dt.getMinutes()).slice(-2);
           var time = hours+ ":" + mins;

        $('#trip_id').val($(this).attr('data-uniqueID'));
        $('#time').val(time);
        $('#myModal').modal();
    });

    $('#confirm_assign').click(function(){
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'assign_taxi',
                trip_id: $('#trip_id').val(),
                taxino: $('#taxino').val(),
                time: $('#time').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                location.reload();
            }
        });
    });

    $('.trip_to_add').on("change",function(){
        requested_trip = $(this).val();
     });

    $('.add_trip').click(function(){
        var scheduled_trip = $(this).attr('scheduled-trip');
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'add_trip',
                request_id: requested_trip,
                schedule_id: scheduled_trip,
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                location.reload();
            }
        });
    });

});    