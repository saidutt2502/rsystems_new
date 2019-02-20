$(document).ready(function () {

$('.btn-clone').click(function(){

    var cloned = '<div class="form-group"><div class="col-sm-3"></div><div class="col-sm-3"><br><span class="input-icon"><input id="update_qty" placeholder="Holiday Name" name="holiday_name[]" type="text" required><i class="ace-icon glyphicon glyphicon-th-list blue"></i></span></div><div class="col-sm-3"><br><span class="input-icon"><input id="update_qty" placeholder="Quantity" name="holiday_date[]" type="date" required><i class="ace-icon fa fa-calendar blue"></i></span></div><div class="col-sm-10 col-md-1"><button type="button" class="btn delete_item btn-danger btn-block btn-xs"><i class="ace-icon fa fa-close bigger-110 icon-only"></i></button></div></div></div>';

    $(cloned).insertAfter(".clone-this");

    $('.newly_added').each(function() {
         var $this = $(this);
         $this.chosen();
         $this.next().css({'width': $this.parent().width()});
     })

     $('.delete_item').click(function(){
         $(this).parent().parent().remove();
     });

 });

});