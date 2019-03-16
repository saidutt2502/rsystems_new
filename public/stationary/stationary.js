$(document).ready(function () {

    //Clearing all the input fields
    $('.form-inline [type="text"]').each(function(){
        $(this).val('');
    });


    //Update stock Functionality
    $('#update_item').click(function(){
        $('#update_item_modal').modal();
    });

    $('#confirm_update').click(function(){
        var item_ids = new Array();
        var item_qty = new Array();

        $('.item_id').each(function(){
                item_ids.push($(this).val());
        });

        $('.updated_qty').each(function(){
                 item_qty.push($(this).val());
        });


        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'update_stock',
                id: item_ids,
                qty: item_qty,
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success) {
                        location.reload();
                }
            }
        });
    });


    //Add Item functionality
    $('#add_item').click(function(){
       
        if($('#code').val()!='' && $('#name').val()!='' && $('#costpu').val()!='' && $('#threshold').val()!='')
        {
        $('#add_item').off('click');
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'add_item',
                code: $('#code').val(),
                name: $('#name').val(),
                costpu: $('#costpu').val(),
                threshold: $('#threshold').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success) {
                        location.reload();
                }
            }
        });
    }
    else
        {
            alert('Please Enter All Fields!');
        }
    });

    //Edit Item functionality
    $('#dynamic-table').on('click','.edit-btn',function(){
        var id = $(this).parent().parent().parent().parent().attr('data-id');

        //Disable clicking again
        $('.edit-btn').off('click');

        //Showing the Done icon
        $(this).parent().parent().children('.done-btn').fadeIn();

        //Converting all the TDs to Input type
        $(this).parent().parent().parent().parent().children('.input-edit').each(function(){
            var current_value = $(this).text();
            var current_type = $(this).attr('data-type');
            $(this).empty();
            $(this).html('<input id="'+current_type+'" value="'+current_value+'" type="text" class="input-small">');
        });

            //AJAX call to update values
            $('.done-btn').click(function(){
                if($('#code_edit').val()!='' && $('#name_edit').val()!='' && $('#costpu_edit').val()!='' && $('#threshold_edit').val()!='' && $('#available_edit').val()!='')
        {
                $.ajax({
                    type: 'post',
                    url: $('#url_ajax').val(),
                    data: {
                        function_name: 'update_item',
                        id: id,
                        code: $('#code_edit').val(),
                        name: $('#name_edit').val(),
                        costpu: $('#costpu_edit').val(),
                        available: $('#available_edit').val(),
                        threshold: $('#threshold_edit').val(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        if (data.success) {

                            // var options = { weekday: 'short', year: 'numeric', month: 'long', day: 'numeric' };
                            // var today  = new Date();

                            // $('.selected').html('<td data-type="code_edit" class="input-edit">'+$('#code_edit').val()+'</td><td data-type="name_edit" class="input-edit">'+$('#name_edit').val()+'</td><td data-type="available_edit" class="input-edit">'+$('#available_edit').val()+'</td><td data-type="costpu_edit" class="input-edit hidden-480">'+$('#costpu_edit').val()+'</td><td data-type="threshold_edit" class="input-edit hidden-480">'+$('#threshold_edit').val()+'</td><td>'+today.toLocaleDateString("en-US", options)+'</td></td><td></td>');

                            // $('.selected').removeClass('selected');

                            // $('.edit-btn').on('click');
                            location.reload();
                        }
                    }
                });
            }
            else
            {
                alert('Please Enter All Fields!');
            } 
        });
    });

    $('#dynamic-table').on('click','.remove-btn',function(){
        var id = $(this).parent().parent().parent().parent().attr('data-id');
        var obj = $(this);
        $('#confirm_delete_modal').modal();

        $('#confirm_delete').click(function(){
            $('#confirm_delete').off('click');
            $.ajax({
                type: 'post',
                url: $('#url_ajax').val(),
                data: {
                    function_name: 'delete_item',
                    id: id,
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                    if (data.success) {
                        obj.parent().parent().parent().parent().hide();
                        $('#confirm_delete_modal').modal('toggle');
                    }
                }
            });
        });
    });

    $('#reset').click(function(){
        $('.form-inline [type="text"]').each(function(){
                $(this).val('');
        });
    });

    $('.btn-clone').click(function(){

        var cloned = '<div class="form-group"><div class="col-sm-12"><div class="col-sm-5"><select  class="chosen-container chosen-container-single chosen-select newly_added item_id">'+$('#first_chosen_list').html()+'</select></div><div class="col-sm-5"><span class="input-icon"><input id="update_qty" placeholder="Quantity" name="qty[]" class="updated_qty" type="text"><i class="ace-icon fa fa-envelope blue"></i></span></div><div class="col-sm-1 col-md-1"><button type="button" class="btn delete_item btn-danger  btn-xs"><i class="ace-icon fa fa-close bigger-110 icon-only"></i></button></div></div></div><br>';
 
        $(cloned).insertAfter(".clone-this");
 
        $('.newly_added').each(function() {
             var $this = $(this);
             $this.chosen();
             $this.next().css({'width': $this.parent().width()});
         })
 
         $('.delete_item').click(function(){
             $(this).parent().parent().parent().remove();
         });
 
     });
  

});
