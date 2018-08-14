$(document).ready(function () {

    var users = {};  

    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'get_user_list',
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            console.log("-----------------------------");
                console.log(data);
         console.log("-----------------------------");
            
            for (var i = 0; i < data.length; i++) 
            {
                users[data[i].name] = data[i].id;
            }

            console.log(users);

            $('input.autocomplete').autocomplete({
                data: users,
                limit: 5, 
              });
            $('#autocomplete-input')
        }
    });

   
    $('.add_hod').click(function(){

  alert(users[$('#autocomplete-input').val()]);
  exit;
  
   $.ajax({
    type: 'post',
    url: $('#url_ajax').val(),
    data: {
        function_name: 'assign_hod',
        hod_name: $('#autocomplete-input').val(),
        dept_id: $(this).attr('data-deptid'),
        '_token': $('input[name=_token]').val()
    },
    success: function (data) {
        location.reload();
    }
});
        

});

});
