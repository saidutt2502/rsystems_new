$(document).ready(function(){

    $('#dept_name_clear').val('');
    $("#selected_dept").val($("#selected_dept option:first").val());
    $('#selected_dept').trigger('chosen:updated');




    $('#selected_dept').on('change', function() {
      

                    //Get Users List
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'get_user_list_sup',
                dept_id:$('#selected_dept').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                console.log(data['selected_user']);
                var option = '';
                var selected_id =[];
                    for(i=0;i<data.all_users.length;i++){
                        for(j=0;j<data.selected_user.length;j++){
                           if(data.all_users[i]['id'] == data.selected_user[j]['id'] ){
                                option = option.concat('<option selected value="'+data.selected_user[j]['id']+'">'+data.selected_user[j]['name']+'</option>')
                                selected_id.push(data.selected_user[j]['id']);
                            }
                               
                           }

                           if(selected_id.indexOf(data.all_users[i]['id']) == -1){
                            option = option.concat('<option  value="'+data.all_users[i]['id']+'">'+data.all_users[i]['name']+'</option>')
                           }
                        }

                  var dualstack_dd = '<select multiple="multiple" size="10" name="user_list[]" id="duallist">'+option+'</select>';

                  $('#insert_here_dd').children().remove();

                  $('#insert_here_dd').append(dualstack_dd);

                  var demo1 = $('select[name="user_list[]"]').bootstrapDualListbox({infoTextFiltered: '<span class="label label-purple label-lg">Filtered</span>'});
                  var container1 = demo1.bootstrapDualListbox('getContainer');
                  container1.find('.btn').addClass('btn-white btn-info btn-bold');
            }
        });
        

    });



});    