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
        var shoes_ids = new Array();
        var shoes_qty = new Array();

        $('.shoes_id').each(function(){
                shoes_ids.push($(this).val());
        });

        $('.updated_qty').each(function(){
                 shoes_qty.push($(this).val());
        });


        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'update_stock',
                id: shoes_ids,
                qty: shoes_qty,
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
    $('#add_shoes').click(function(){
        
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'add_shoes',
                brand: $('#brand').val(),
                size: $('#size').val(),
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
    });

    //Edit Item functionality
    $('.edit-btn').click(function(){
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
            
                $.ajax({
                    type: 'post',
                    url: $('#url_ajax').val(),
                    data: {
                        function_name: 'update_shoes',
                        id: id,
                        brand: $('#brand_edit').val(),
                        size: $('#size_edit').val(),
                        costpu: $('#costpu_edit').val(),
                        available: $('#available_edit').val(),
                        threshold: $('#threshold_edit').val(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        if (data.success) {
                                location.reload();
                        }
                    }
                }); 
        });
    });

    $('.remove-btn').click(function(){
        var id = $(this).parent().parent().parent().parent().attr('data-id');
        $('#confirm_delete_modal').modal();

        $('#confirm_delete').click(function(){
            $.ajax({
                type: 'post',
                url: $('#url_ajax').val(),
                data: {
                    function_name: 'delete_shoes',
                    id: id,
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                    if (data.success) {
                         location.reload();
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

        var cloned = '<div class="form-group"><div class="col-sm-12"><div class="col-sm-5"><select  class="chosen-container chosen-container-single chosen-select newly_added shoes_id">'+$('#first_chosen_list').html()+'</select></div><div class="col-sm-5"><span class="input-icon"><input id="update_qty" placeholder="Quantity" name="qty[]" class="updated_qty" type="text"><i class="ace-icon fa fa-envelope blue"></i></span></div><div class="col-sm-1 col-md-1"><button type="button" class="btn delete_item btn-danger  btn-xs"><i class="ace-icon fa fa-close bigger-110 icon-only"></i></button></div></div></div><br>';
 
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
