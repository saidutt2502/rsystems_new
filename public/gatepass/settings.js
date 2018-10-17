$(document).ready(function () {

    
    $('#add').click(function(){
        $('#add_shift').append('<div class="col-md-12 remove"><div class="col-md-3 col-sm-3"><label>Shift Name</label><input autocomplete="off" type="text" class="form-control" name="name[]" required autofocus><br></div><div class="col-md-2 col-sm-2"><label>From</label><input autocomplete="off" type="time" class="form-control" name="from[]"  required></div><div class="col-md-2 col-sm-2"><label>To</label><input autocomplete="off" type="time" class="form-control" name="to[]"  required></div><div class="col-md-2 col-sm-2"><br><button type="button" class="btn btn-sm btn-danger del_btn">-</button></div></div>');
        $('#reset').click(function()
        {
           $(".remove").remove();
        });
        $('.del_btn').click(function(){
            $(this).parent().parent().remove();
            });
    });

    $('.del_btn').click(function(){
        $(this).parent().parent().remove();
        });
});