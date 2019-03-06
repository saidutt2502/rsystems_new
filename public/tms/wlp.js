$(document).ready(function(){

    $('#dept_name_clear').val('');
    $("#selected_dept").val($("#selected_dept option:first").val());
    $('#selected_dept').trigger('chosen:updated');


    $('#add_wk').on('click', function() {

        var new_row = '<div><br><br><br><label class="col-sm-3 control-label no-padding-right"></label><div class="col-sm-9"><input name="wk[]" class="col-xs-10 col-sm-5" type="text">&nbsp;&nbsp;&nbsp;<button class="btn btn-danger remove_row_wk btn-xs" type="button"><i class="ace-icon fa fa-minus bigger-110"></i></button></div></div>';

        $('#append_to_this_wk').append(new_row);

        $('.remove_row_wk').on('click', function(){
               $(this).parent().parent().remove();
        });

    });

    $('#add_lines').on('click', function() {

        var new_row = '<div><br><br><br><label class="col-sm-3 control-label no-padding-right"></label><div class="col-sm-9"><input name="lines[]" class="col-xs-10 col-sm-5" type="text">&nbsp;&nbsp;&nbsp;<button class="btn btn-danger remove_row_lines btn-xs" type="button"><i class="ace-icon fa fa-minus bigger-110"></i></button></div></div>';

        $('#append_to_this_lines').append(new_row);

        $('.remove_row_lines').on('click', function(){
               $(this).parent().parent().remove();
        });

    });


    $('#add_products').on('click', function() {

        var new_row = '<div><br><br><br><label class="col-sm-3 control-label no-padding-right"></label><div class="col-sm-9"><input name="products[]" class="col-xs-10 col-sm-5" type="text">&nbsp;&nbsp;&nbsp;<button class="btn btn-danger remove_row_products btn-xs" type="button"><i class="ace-icon fa fa-minus bigger-110"></i></button></div></div>';

        $('#append_to_this_products').append(new_row);

        $('.remove_row_products').on('click', function(){
               $(this).parent().parent().remove();
        });

    });

    $('#selected_dept').on('change', function() {
        $('.remove_this_on_change_wk').remove();
        $('.remove_this_on_change_lines').remove();
        $('.remove_this_on_change_products').remove();
        //Get company List
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'get_wk_list',
                dept_id:$('#selected_dept').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                $.each(data, function () {
                var new_row = '<div class="remove_this_on_change_wk"><br><br><br><label class="col-sm-3 control-label no-padding-right"></label><div class="col-sm-9"><input name="wk[]" class="col-xs-10 col-sm-5" value="'+this.name+'" type="text">&nbsp;&nbsp;&nbsp;<button class="btn btn-danger remove_row_wk btn-xs" type="button"><i class="ace-icon fa fa-minus bigger-110"></i></button></div></div>';

                    $('#append_to_this_wk').append(new_row);

                    $('.remove_row_wk').on('click', function(){
                        $(this).parent().parent().remove();
                    });
                });
            }
        });

        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'get_lines_list',
                dept_id:$('#selected_dept').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                $.each(data, function () {
                var new_row = '<div class="remove_this_on_change_lines"><br><br><br><label class="col-sm-3 control-label no-padding-right"></label><div class="col-sm-9"><input name="lines[]" class="col-xs-10 col-sm-5" value="'+this.name+'" type="text">&nbsp;&nbsp;&nbsp;<button class="btn btn-danger remove_row_lines btn-xs" type="button"><i class="ace-icon fa fa-minus bigger-110"></i></button></div></div>';

                    $('#append_to_this_lines').append(new_row);

                    $('.remove_row_lines').on('click', function(){
                        $(this).parent().parent().remove();
                    });
                });
            }
        });

        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'get_products_list',
                dept_id:$('#selected_dept').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                $.each(data, function () {
                var new_row = '<div class="remove_this_on_change_products"><br><br><br><label class="col-sm-3 control-label no-padding-right"></label><div class="col-sm-9"><input name="products[]" class="col-xs-10 col-sm-5" value="'+this.name+'" type="text">&nbsp;&nbsp;&nbsp;<button class="btn btn-danger remove_row_products btn-xs" type="button"><i class="ace-icon fa fa-minus bigger-110"></i></button></div></div>';

                    $('#append_to_this_products').append(new_row);

                    $('.remove_row_products').on('click', function(){
                        $(this).parent().parent().remove();
                    });
                });
            }
        });

    });



});    