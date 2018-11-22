$(document).ready(function(){

    $('#dept_name_clear').val('');
    $("#selected_dept").val($("#selected_dept option:first").val());
    $('#selected_dept').trigger('chosen:updated');


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

    $('#add_vendor').on('click', function() {

        var new_row = '<div><br><br><br><label class="col-sm-3 control-label no-padding-right"></label><div class="col-sm-9"><input name="company[]" class="col-xs-10 col-sm-5" type="text">&nbsp;&nbsp;&nbsp;<button class="btn btn-danger remove_row btn-xs" type="button"><i class="ace-icon fa fa-minus bigger-110"></i></button></div></div>';

        $('#append_to_this').append(new_row);

        $('.remove_row').on('click', function(){
               $(this).parent().parent().remove();
        });

    });

    $('#selected_dept').on('change', function() {
        $('.remove_this_on_change').remove();
        $('#dept_name_clear').val( $('#selected_dept').find(":selected").text());
        //Get company List
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'get_company_list',
                dept_id:$('#selected_dept').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                $.each(data, function () {
                var new_row = '<div class="remove_this_on_change"><br><br><br><label class="col-sm-3 control-label no-padding-right"></label><div class="col-sm-9"><input name="company[]" class="col-xs-10 col-sm-5" value="'+this.name+'" type="text">&nbsp;&nbsp;&nbsp;<button class="btn btn-danger remove_row btn-xs" type="button"><i class="ace-icon fa fa-minus bigger-110"></i></button></div></div>';

                    $('#append_to_this').append(new_row);

                    $('.remove_row').on('click', function(){
                        $(this).parent().parent().remove();
                    });
                });
            }
        });

        if( $('#selected_dept').val()=='0'){
            $('#dept_name_clear').val('');
            $.ajax({
                type: 'post',
                url: $('#url_ajax').val(),
                data: {
                    function_name: 'get_all_users',
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                    var option = '';
                $.each(data, function () {
                    option = option.concat('<option value="'+this.id+'">'+this.name+'</option>')
                  });
                  var dualstack_dd = '<select multiple="multiple" size="10" name="user_list[]" id="duallist">'+option+'</select>';

                  $('#insert_here_dd').children().remove();

                  $('#insert_here_dd').append(dualstack_dd);

                  var demo1 = $('select[name="user_list[]"]').bootstrapDualListbox({infoTextFiltered: '<span class="label label-purple label-lg">Filtered</span>'});
                  var container1 = demo1.bootstrapDualListbox('getContainer');
                  container1.find('.btn').addClass('btn-white btn-info btn-bold');
                }
            });
        }else{
                    //Get Users List
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'get_user_list',
                dept_id:$('#selected_dept').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                console.log(data);
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
        }

    });



});    