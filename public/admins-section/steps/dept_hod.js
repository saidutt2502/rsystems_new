$(document).ready(function () {

    $('.show-details-btn').on('click', function(e) {
        e.preventDefault();
        $(this).closest('tr').next().toggleClass('open');
        $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
    });


    if(!ace.vars['touch']) {
        $('.chosen-select').chosen({allow_single_deselect:true}); 
        //resize the chosen on window resize

        $(window)
        .off('resize.chosen')
        .on('resize.chosen', function() {
            $('.chosen-select').each(function() {
                 var $this = $(this);
                 $this.next().css({'width': '100%'});

                 if($(this).val($(this).attr('data-hod')) !== 'NULL'){
                    $(this).val($(this).attr('data-hod'));
                    $(this).trigger("chosen:updated");
                }
                 
            })
        }).trigger('resize.chosen');
        //resize chosen on sidebar collapse/expand
        $(document).on('settings.ace.chosen', function(e, event_name, event_val) {
            if(event_name != 'sidebar_collapsed') return;
            $('.chosen-select').each(function() {
                 var $this = $(this);
                 $this.next().css({'width': $this.parent().width()});
            })
        });

    }


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
                    alert('HoD assigned');
            }
        });
    
     });
    });
