$(document).ready(function () {

    //Setting Menu items to active
    $('li').removeClass('active');
    $('#hk_request_li_to_be').addClass('active');
    $('#item-nav-menu_hk').css("display","block");
    $('#item-nav-menu_hk').removeClass('nav-hide');
    $('#item-nav-menu_hk').addClass('nav-show');

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