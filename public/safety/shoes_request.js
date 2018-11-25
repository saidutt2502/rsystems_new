$(document).ready(function () {

    
    $('.btn-clone').click(function(){

       var cloned = '<div class="form-group"><label class="col-sm-3 control-label no-padding-right">Request</label><div class="col-sm-9"><div class="col-sm-5"><select name="shoes_id[]" class="chosen-container chosen-container-single chosen-select newly_added">'+$('#shoes_id').html()+'</select></div><div class="col-sm-3"><span class="input-icon"><input id="emp_id" placeholder="Employee Ids" name="emp_id[]" type="text"><i class="ace-icon fa fa-barcode blue"></i></span></div><div class="col-sm-10 col-md-1"><button type="button" class="btn delete_item btn-danger btn-block btn-xs"><i class="ace-icon fa fa-close bigger-110 icon-only"></i></button></div></div></div>';

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