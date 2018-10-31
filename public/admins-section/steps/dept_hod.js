$(document).ready(function () {

    $('.chosen-select').each(function() {
        var $this = $(this);
        $this.next().css({'width': '100%'});

        if($(this).val($(this).attr('data-hod')) !== 'NULL'){
           $(this).val($(this).attr('data-hod'));
           $(this).trigger("chosen:updated");
       }
   })

    $('.show-details-btn').on('click', function(e) {
        e.preventDefault();
        $(this).closest('tr').next().toggleClass('open');
        $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
    });


    $('.add_hod').on("change",function(){
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'assign_hod',
                user_id: $(this).val(),
                dept_id: $(this).attr('data-dept-id'),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                    alert('Hod assigned');
            }
        });
    
     });
    });
