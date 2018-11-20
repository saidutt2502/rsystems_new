$(document).ready(function(){

    $('#add_vendor').on('click', function() {

        var new_row = '<div><br><br><br><label class="col-sm-3 control-label no-padding-right"></label><div class="col-sm-9"><input name="vendor" class="col-xs-10 col-sm-5" type="text">&nbsp;&nbsp;&nbsp;<button class="btn btn-danger remove_row btn-xs" type="button" id="add_vendor"><i class="ace-icon fa fa-minus bigger-110"></i></button></div></div>';

        $('#append_to_this').append(new_row);

        $('.remove_row').on('click', function(){
               $(this).parent().parent().remove();
        });

    });

});    