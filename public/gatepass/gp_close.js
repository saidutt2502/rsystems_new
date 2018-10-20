$(document).ready(function(){

    $('.close-btn').click(function(){
        var dt = new Date();
           var hours = ('0'+dt.getHours()).slice(-2);
           var mins = ('0'+dt.getMinutes()).slice(-2);
           var time = hours+ ":" + mins;

        $('#entry_id').val($(this).attr('data-uniqueID'));
        $('#time').val(time);
        $('#myModal').modal();
    });

    $('#confirm_close').click(function(){
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'entry_close',
                entry_id: $('#entry_id').val(),
                date: $('#date').val(),
                time: $('#time').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                location.reload();
            }
        });
    });


    $('.close-in-btn').click(function(){
        var dt = new Date();
           var hours = ('0'+dt.getHours()).slice(-2);
           var mins = ('0'+dt.getMinutes()).slice(-2);
           var time = hours+ ":" + mins;

        $('#entry_id1').val($(this).attr('data-uniqueID1'));
        $('#time1').val(time);
        $('#myModal1').modal();
    });

    $('#confirm_close_in').click(function(){
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'entry_close_in',
                entry_id: $('#entry_id1').val(),
                date: $('#date1').val(),
                time: $('#time1').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                location.reload();
            }
        });
    });

  });