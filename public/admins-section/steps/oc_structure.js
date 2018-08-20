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
    
    $('#dept').on("change",function(){
        $('.to_remove').remove();
        $.ajax({
                type: 'post',
                url: $('#url_ajax').val(),
                data: {
                    function_name: 'retrieve_levels',
                    dept_id: $('#dept').val(),
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                    var levels = data[0].oc_levels;
                    var i;
                    $('#levels').append('<option class="to_remove" value="" disabled selected>Select Line</option>');
                    for(i=2;i<=levels;i++)
                    {
                        $('#levels').append('<option class="to_remove" value="'+i+'">Line '+i+'</option>');
                    }
                    $('.chosen-select').trigger("chosen:updated");
                   
                    
                }
            });
     });

     //Only Second Line

     $('#add_emp').click(function(){
                        
                       
        $.ajax({
         type: 'post',
         url: $('#url_ajax').val(),
         data: {
             function_name: 'add_reporting',
             dept_id: $('#dept').val(),
             reportee: $('#user_id').val(),
             level:  $('#levels').val(),
             reporter:  $('#hod_id').val(),
             '_token': $('input[name=_token]').val()
         },
         success: function (data) {
             $('#user_id').val("");
             $('#user_id').trigger("chosen:updated");
             $('.added_employees').append('<tr id="'+data[0].id+'"><td><a href="#!">'+data[0].emp_id+'</a></td><td><a href="#!">'+data[0].name+'</a></td><td class="hidden-480"><center><div class="btn-group"><button class="btn btn-sm btn-danger del_emp" user-id="'+data[0].id+'"><i class="ace-icon fa fa-trash-o bigger-120"></i></button></div></center></td></tr>');
               $('.del_emp').click(function(){
            
                var user_id=$(this).attr('user-id');
                $.ajax({
                 type: 'post',
                 url: $('#url_ajax').val(),
                 data: {
                     function_name: 'del_reporting',
                     dept_id: $('#dept').val(),
                     reportee: $(this).attr('user-id'),
                     level:  $('#levels').val(),
                     '_token': $('input[name=_token]').val()
                 },
                 success: function (data) {
                    $('#'+user_id).fadeOut();  
                 }
             });
             });     
         }
     });
     });


    $('.del_emp').click(function(){
            
                var user_id=$(this).attr('user-id');
                $.ajax({
                 type: 'post',
                 url: $('#url_ajax').val(),
                 data: {
                     function_name: 'del_reporting',
                     dept_id: $('#dept').val(),
                     reportee: user_id,
                     level:  $('#levels').val(),
                     '_token': $('input[name=_token]').val()
                 },
                 success: function (data) {
                    $('#'+user_id).fadeOut();  
                 }
             });
             });


 // All Other Lines 

             $('.add_emp1').click(function(){
              var reporter_id= $(this).attr('reporter-id');         
                       
                $.ajax({
                 type: 'post',
                 url: $('#url_ajax').val(),
                 data: {
                     function_name: 'add_reporting',
                     dept_id: $('#dept').val(),
                     level:  $('#levels').val(),
                     reportee: $('.user_id').val(),
                     reporter: reporter_id ,
                     '_token': $('input[name=_token]').val()
                 },
                 success: function (data) {
                    $('.user_id').val("");
                    $('.user_id').trigger("chosen:updated");
                     $('#'+reporter_id+'_add').append('<div class="col-xs-12 col-sm-7 col-sm-offset-2 " id="remove_'+data[0].id+'"><div class="col-xs-12 col-sm-12 col-md-12 widget-container-col ui-sortable" id="widget-container-col-3"><div class="widget-box collapsed ui-sortable-handle" id="widget-box-3"><div class="widget-header widget-header-small"><h6 class="widget-title each_dept_name">'+data[0].name+' (Emp Id: '+data[0].emp_id+')</h6><div class="widget-toolbar hidden-480"><a href="#"><i class="ace-icon fa fa-times red2 del_emp1" user-id="'+data[0].id+'"></i></a></div></div></div></div></div>');   
                 
                     $('.del_emp1').click(function(){
            
                        var user_id=$(this).attr('user-id');
                        $.ajax({
                         type: 'post',
                         url: $('#url_ajax').val(),
                         data: {
                             function_name: 'del_reporting',
                             dept_id: $('#dept').val(),
                             reportee: $(this).attr('user-id'),
                             level:  $('#levels').val(),
                             '_token': $('input[name=_token]').val()
                         },
                         success: function (data) {
                            $('#remove_'+user_id).fadeOut();  
                         }
                     });
                     });

                    }
             });
             });

             $('.del_emp1').click(function(){
            
                var user_id=$(this).attr('user-id');
                $.ajax({
                 type: 'post',
                 url: $('#url_ajax').val(),
                 data: {
                     function_name: 'del_reporting',
                     dept_id: $('#dept').val(),
                     reportee: $(this).attr('user-id'),
                     level:  $('#levels').val(),
                     '_token': $('input[name=_token]').val()
                 },
                 success: function (data) {
                    $('#remove_'+user_id).fadeOut();  
                 }
             });
             });

  });