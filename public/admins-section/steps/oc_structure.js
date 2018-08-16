$(document).ready(function(){
    $('select').formSelect();
    
    $('#dept').on("change",function(){
        $('.to_remove').remove();
        $('.table_remove').remove();
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
                    $('#levels').formSelect();
                    
                }
            });
     });

     $('#levels').on("change",function(){
        $('.table_remove').remove();
        if($('#levels').val()=='2')
        {
            var table;
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'get_list_user',
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                console.log(data);
                table='<table class="striped table_remove"><thead><tr><td>Employee Id</td><td>Name</td><td></tr></tr></thead><tbody>';
                for(i=0;i<data.length;i++)
                    {
                        table+='<tr><td>'+data[i].emp_id+'</td><td>'+data[i].name+'</td><td><i class="material-icons prefix add_emp" user-id="'+data[i].id+'">add</i></td></tr>';
                    }
                    table+='</tbody></table>';
                    $('#add_table').append(table); 
                    
                    $('.add_emp').click(function(){
                        
                       
                       $.ajax({
                        type: 'post',
                        url: $('#url_ajax').val(),
                        data: {
                            function_name: 'add_reporting',
                            dept_id: $('#dept').val(),
                            reportee: $(this).attr('user-id'),
                            level:  $('#levels').val(),
                            reporter:  $('#hod_id').val(),
                            '_token': $('input[name=_token]').val()
                        },
                        success: function (data) {
                            
                            
                        }
                    });
                    });
                         
            }
        });
      }
     });

  });