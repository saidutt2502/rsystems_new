$(document).ready(function () {

    //Setting Menu items to active
    $('li').removeClass('active');
    $('#stationary_request_li_to_be').addClass('active');
    $('#item-nav-menu').css("display","block");
    $('#item-nav-menu').removeClass('nav-hide');
    $('#item-nav-menu').addClass('nav-show');

    $( "#update_qty" ).change(function() {
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'check_qty',
                item_id: $('#item_id').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) 
            {
                if (data.available<$('#update_qty').val())
                {
                    alert('Quantity Unavailable In Stock At The Moment!\n\nAvailable Quantity:'+data.available);
                    $('#update_qty').val(''); 
                }
            }   
        });
    });

    $('.btn-clone').click(function(){

       var cloned = '<div class="form-group"><label class="col-sm-3 control-label no-padding-right">Request</label><div class="col-sm-9"><div class="col-sm-5"><select name="item_id[]" class="chosen-container chosen-container-single chosen-select newly_added">'+$('#item_id').html()+'</select></div><div class="col-sm-3"><span class="input-icon"><input id="update_qty" placeholder="Quantity" name="qty[]" type="text"><i class="ace-icon fa fa-envelope blue"></i></span></div><div class="col-sm-10 col-md-1"><button type="button" class="btn delete_item btn-danger btn-block btn-xs"><i class="ace-icon fa fa-close bigger-110 icon-only"></i></button></div></div></div>';

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