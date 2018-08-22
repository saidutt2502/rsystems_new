$(document).ready(function(){

    $('.nav-tabs li:eq(1) a').tab('show');

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

    $('.allocate_cc').click(function(){
        
        var user_id = $(this).attr('user-id');
       
                       
        $.ajax({
         type: 'post',
         url: $('#url_ajax').val(),
         data: {
             function_name: 'allocate_cc',
             user_id: user_id,
             cc_id: $('#'+user_id+'_cc').val(),
             module_id: $('#'+user_id+'_module').val(),
             budget:  $('#'+user_id+'_budget').val(),
             '_token': $('input[name=_token]').val()
         },
         success: function (data) {
             $('#'+user_id+'_table').append('<tr id="'+data[0].cc2m_id+'_entries"><td>'+data[0].number+'</td><td>'+data[0].m_name+'</td><td contenteditable class="edit_budget" entry-id="'+data[0].cc2m_id+'">'+data[0].budget+'</td><td>'+data[0].actual+'</td><td class="hidden-480"><center><div class="btn-group"><button class="btn btn-sm btn-danger delete_allocation" entry-id="'+data[0].cc2m_id+'"><i class="ace-icon fa fa-trash-o bigger-120"></i></button></div></center></td></tr>')

             $('#'+user_id+'_cc').val("");
             $('#'+user_id+'_cc').trigger("chosen:updated");

             $('#'+user_id+'_module').val("");
             $('#'+user_id+'_module').trigger("chosen:updated");

             $('#'+user_id+'_budget').val("");
             

             $('.delete_allocation').click(function(){
        
                var entry_id = $(this).attr('entry-id');
               
                               
                $.ajax({
                 type: 'post',
                 url: $('#url_ajax').val(),
                 data: {
                     function_name: 'del_allocate_cc',
                     entry_id: entry_id,
                     '_token': $('input[name=_token]').val()
                 },
                 success: function (data) {
                     $('#'+entry_id+'_entries').fadeOut();
                       
                 }
             });
             });

             $('.edit_budget').blur(function(){

        
        
                $.ajax({
                    type: 'post',
                    url: $('#url_ajax').val(),
                    data: {
                        function_name: 'edit_budget',
                        entry_id: $(this).attr('entry-id'),
                        content: $(this).text(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                              
                    }
                });
                
                
            });
               
         }
     });
     });

     $('.delete_allocation').click(function(){
        
        var entry_id = $(this).attr('entry-id');
       
                       
        $.ajax({
         type: 'post',
         url: $('#url_ajax').val(),
         data: {
             function_name: 'del_allocate_cc',
             entry_id: entry_id,
             '_token': $('input[name=_token]').val()
         },
         success: function (data) {
             $('#'+entry_id+'_entries').fadeOut();
               
         }
     });
     });

     $('.edit_budget').blur(function(){

        
        
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'edit_budget',
                entry_id: $(this).attr('entry-id'),
                content: $(this).text(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                      
            }
        });
        
        
    });
});