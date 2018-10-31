$(document).ready(function () {

    $('.chosen-select').each(function() {
        var $this = $(this);
        $this.next().css({'width': '100%'});

        if($(this).val($(this).attr('data-adminID')) !== 'NULL'){
           $(this).val($(this).attr('data-adminID'));
           $(this).trigger("chosen:updated");
       }
   })


   $('.show-details-btn').on('click', function(e) {
    e.preventDefault();
    $(this).closest('tr').next().toggleClass('open');
    $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
});


$('.add_admin').on("change",function(){
    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'assign_admin2module',
            user_id: $(this).val(),
            module_id: $(this).attr('data-moduleID'),
            dept_id: $(this).attr('dept-id'),
            tbl_id: $(this).attr('data-tbid'),
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
                $('#myModal').modal();
        }
    });

 });

});