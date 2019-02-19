$(document).ready(function(){

$('.show-details-btn').on('click', function(e) {
    e.preventDefault();
    $(this).closest('tr').next().toggleClass('open');
    $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
});

$(".planned_entry").blur(function(){
    var data_entered=$(this).html();
    var entry_id=$(this).attr('entry-id');

    
    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'update_planned',
            data: data_entered,
            id: entry_id,
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            if (data.success) {
                    
            }
        }
    });
});

$(".achived_entry").blur(function(){
    var data_entered=$(this).html();
    var entry_id=$(this).attr('entry-id');

    
    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'update_achived',
            data: data_entered,
            id: entry_id,
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            if (data.success) {
                    
            }
        }
    });
});

$('#publish').click(function(){

    $('#confirm_changes').modal('toggle');
    
 
});

$('#publish_confirm').click(function(){

    $('#confirm_publish').modal('toggle');
    
 
});

$('#publish_btn').click(function(){
    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'publish_list',
            deptid:$('#dept_selected').val(),
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
                 $('#confirm_publish').modal('toggle');
        }
    });
    
 
});

$('#confirm_save').click(function(){

    location.reload();
    
 
});

});