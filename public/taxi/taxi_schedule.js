$(document).ready(function(){
    $('#home_tab_first').addClass('active');

    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }


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
                trip_type: $("input[name='type_of_trip']:checked").val(),
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

    

    
    $("input[name='lead']:checked").change(function(){
        alert('hi');
     });

    $('.validate-btn').click(function(){
        var validate_trip = $(this).attr('data-validate');
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'validate_trip',
                trip_id: validate_trip,
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                location.reload();
            }
        });
    });

    $('.edit-btn').click(function(){
        var id=$(this).attr('data-edit');
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'get_trip_schedule',
                trip_id: id,
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                $('#schedule_id').val(id);
                $('#start_date').val(data[0]['start_date']);
                $('#date_close').val(data[0]['end_date']);
                $('#start_time').val(data[0]['start_time']);
                $('#time_close').val(data[0]['end_time']);
                $('#start_kms').val(data[0]['start_km']);
                $('#close_kms').val(data[0]['end_km']);
                $('#extra_costs').val(data[0]['extra_cost']);
                $('#wait_time').val(data[0]['wait_time']);
                $('#remarks').val(data[0]['remarks']);
                
            }
        });
        $('#myModal_edit').modal();
    });

    $('#confirm_finish').click(function(){
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'edit_trip_schedule',
                trip_id: $('#schedule_id').val(),
                start_date: $('#start_date').val(),
                close_date: $('#date_close').val(),
                start_time: $('#start_time').val(),
                close_time: $('#time_close').val(),
                start_kms: $('#start_kms').val(),
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
    });

    $('.unassign-btn').click(function(){
        $('#schedule_id').val($(this).attr('data-uniqueID'));
        $('#UnassignModal').modal();
    });

    $('#confirm_unassign').click(function(){
        
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'unassign_taxi',
                schedule_id: $('#schedule_id').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
              location.reload();
            }
        });
    });

    $('.delete-btn').click(function(){
        $('#trip_id').val($(this).attr('data-uniqueID'));
        $('#DeleteModal').modal();
    });

    $('#confirm_delete').click(function(){
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'delete_taxi_request',
                trip_id: $('#trip_id').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                location.reload();
            }
        });
    });

    $(".confirm_lead").click(function(){
        var schedule_id=$(this).attr('schedule-id');
        var radioValue = $("input[name='lead_"+schedule_id+"']:checked").val();
      

        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'update_lead_passenger',
                request_id: radioValue,
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                location.reload();
                
            }
        });
        
    });

    // $('.delete_list').click(function(){

    //     $.ajax({
    //         type: 'post',
    //         url: $('#url_ajax').val(),
    //         data: {
    //             function_name: 'unassign_single_trip',
    //             request_id: $(this).attr('request-id'),
    //             schedule_id: $(this).attr('schedule-id'),
    //             '_token': $('input[name=_token]').val()
    //         },
    //         success: function (data) {
                
                
    //         }
    //     });
        
    // });

});    