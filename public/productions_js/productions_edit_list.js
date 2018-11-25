$(document).ready(function(){
    
    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'get_edit_list',
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            var option = '';
            var selected_id =[];
                if(data.selected_user.length >0 ){
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

                       var dualstack_dd = '<select multiple="multiple" size="10" name="user_list[]" id="duallist">'+option+'</select>';

                       $('#insert_here_dd').children().remove();
         
                       $('#insert_here_dd').append(dualstack_dd);
         
                       var demo1 = $('select[name="user_list[]"]').bootstrapDualListbox({infoTextFiltered: '<span class="label label-purple label-lg">Filtered</span>'});
                       var container1 = demo1.bootstrapDualListbox('getContainer');
                       container1.find('.btn').addClass('btn-white btn-info btn-bold');
                    }
                }else{
                    $.ajax({
                        type: 'post',
                        url: $('#url_ajax').val(),
                        data: {
                            function_name: 'get_all_users',
                            '_token': $('input[name=_token]').val()
                        },
                        success: function (data) {
                            $.each(data, function () {
                                $('#duallist').append('<option value="'+this.id+'">'+this.name+'</option>');
                              });
                
                              var demo1 = $('select[name="user_list[]"]').bootstrapDualListbox({infoTextFiltered: '<span class="label label-purple label-lg">Filtered</span>'});
                              var container1 = demo1.bootstrapDualListbox('getContainer');
                              container1.find('.btn').addClass('btn-white btn-info btn-bold');
                        }
                    });
                }

             
        }
    });
        
});