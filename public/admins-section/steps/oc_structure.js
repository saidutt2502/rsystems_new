$(document).ready(function(){

    $(".chosen-select").each(function(){
        $(".chosen-select").chosen({width: "100%"}); 
    });
    $('select').formSelect();
    
    $('#dept').on("change",function(){
        $('.to_remove').remove();
        $('.to_clear').remove();
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
                    $('#levels').append('<option class="to_remove" value="" disabled selected>Select Line to Initialize</option>');
                    for(i=2;i<=levels;i++)
                    {
                        $('#levels').append('<option class="to_remove" value="'+i+'">Line '+i+'</option>');
                    }
                    $('.chosen-select').trigger("chosen:updated");
                   
                    
                }
            });
     });

     $('#levels').on("change",function(){
        $('.to_clear').remove();

        if($('#levels').val()=='2')
        {

            var body='';
            var form;
            var i;
          
            $.ajax({
                type: 'post',
                url: $('#url_ajax').val(),
                data: {
                    function_name: 'retrieve_hierarchy',
                    dept_id: $('#dept').val(),
                    level:  $('#levels').val(),
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                 
                    for(i=0;i<data.length;i++)
            {
                body+='<tr id="'+data[i].id+'"><td>'+data[i].emp_id+'</td><td>'+data[i].name+'</td><td><i class="material-icons prefix del_emp" user-id="'+data[i].id+'">close</i></td></tr>';
            }
            
                    
                }
            });

        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'get_list_user',
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                form='<div class="row"><table class="to_clear"><tbody><tr><td><select  id="user_id" class="chosen-select refresh "><option value="" disabled selected>Select User</option>'
                for(i=0;i<data.length;i++)
                {
                    form+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
                }
                form+='</select></td><td><i class="material-icons prefix add_emp">add</i><td></tr></tbody></table><table class="striped to_clear" id="added_employees"><thead><tr><th>Employee Id</th><th>Employee Name</th><th></th></tr></thead><tbody>'+body+'</tbody></table></div>';
    
                
                $('#add_table').append(form);
                $(".chosen-select").each(function(){
                    $(".chosen-select").chosen({width: "100%"}); 
                });

                $('.add_emp').click(function(){
                        
                       
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
                         $('.refresh').val("");
                         $('.refresh').trigger("chosen:updated");
                         $('#added_employees').append('<tr id="'+data[0].id+'"><td>'+data[0].emp_id+'</td><td>'+data[0].name+'</td><td><i class="material-icons prefix del_emp" user-id="'+data[0].id+'">close</i></td></tr>');
                         
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
      
      }
      else
      {
        var previous_line='';
        var form;
        var i;
        var title_1=$('#levels').val()-1;

        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'retrieve_hierarchy',
                dept_id: $('#dept').val(),
                level:  $('#levels').val()-1,
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
             
                for(i=0;i<data.length;i++)
        {
            previous_line+='<li class="collection-item avatar "><table align="center"><thead><tr><th><h6>'+data[i].name+'</h6></th><th><a href="#!" add_dept2location"><i class="material-icons">send</i></a></th></tr></thead></table></li>';
        }
        
                
            }
        });

        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'get_list_user',
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                form ='<div class="row"><table class="to_clear"><tbody><tr><td><select  id="user_id" class="chosen-select refresh " disabled><option value="" disabled selected>Select User</option>'
                for(i=0;i<data.length;i++)
                {
                    form+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
                }
                form+='</select></td><td><i class="material-icons prefix add_emp">add</i></td></tr></tbody></table><div class="container to_clear" align="center"><div class = "col m6"><ul class="collection with-header" id="location_collection"><li class="collection-header"><h4>Line '+title_1+'</h4></li>'+previous_line+'</ul></div></div></div>';
                
                $('#add_table').append(form);
                $(".chosen-select").each(function(){
                    $(".chosen-select").chosen({width: "100%"}); 
                });
                               
            } 

            

        });
      }
      

    });

  });