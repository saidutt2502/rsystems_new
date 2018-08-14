
$(document).ready(function () {

    //Setting Current Selected Location to 0
    var current_location = 0;

    //Function to add Departments to locations
    $(".add_dept2location").click(function () {
        var obj = $(this);
        $('.lighten-2').removeClass('grey lighten-2');
        $('.remove-only').remove();
        current_location = obj.attr('open-id');
        obj.parent().addClass('grey lighten-2');

        //Ajax Call to List all the departments for the current location
        $.ajax({
            type: 'post',
            url: $('#url_ajax').val(),
            data: {
                function_name: 'list_departments',
                id: obj.attr('open-id'),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success) {

                    // Append to Department List
                    for (var i = 0; i < data.data.length; i++) {
                        $('#department_collection').append('<li class="collection-item remove-only"><div><strong class="dept_name_check">' + data.data[i]['name'] + '</strong><a href="#!" class="secondary-content"><i class="material-icons delete_dept" remove_dept=' + data.data[i]['id'] + '>cancel</i></a></li>');
                    }

                    //Function to delete to Locations Collection
                    $(".delete_dept").click(function () {
                        delete_department($(this));
                    });

                }
            }
        })
    });


    //Function to append to Locations Collection
    $("#add_location_ico").click(function () {

        //Initializing the location array with all the location names
        location_names = new Array();
        $('.title').each(function (index, value) {
            location_names.push($(this).text().toLowerCase());
        });

        if ($('.location_name').val() != '') {
            if (location_names.indexOf($('.location_name').val().toLowerCase()) == -1) {
                // Ajax Call to Add to database
                $.ajax({
                    type: 'post',
                    url: $('#url_ajax').val(),
                    data: {
                        function_name: 'add_location',
                        name: $('.location_name').val(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        if (data.success) {
                            // Append to Locations List
                            $('#location_collection').append(' <li class="collection-item avatar "><i class="material-icons circle red delete_location" remove-id=' + data.insert_id + ' >remove</i><span class="title">' + $('.location_name').val() + '</span><p>First Line</p><a href="#!" class="secondary-content" open-id=' + data.insert_id + '><i class="material-icons">send</i></a></li>');

                            location.reload();
                        }
                    }
                })
            } else {
                $('#error_msg').text('Location already Exists !');
                $('#error_modal').modal('open');
                $('.location_name').val('');
            }
        }
    });

    //Function to delete to Department Collection
    $(".delete_location").click(function () {
        delete_location($(this));
    });

    //Function to append to Department Collection
    $("#add_department_ico").click(function () {

        //Initializing the Department_name array with all the location names
        department_names = new Array();
        $('.dept_name_check').each(function (index, value) {
            department_names.push($(this).text().toLowerCase());
        });

        if ($('.department_name').val() != '') {
            if (department_names.indexOf($('.department_name').val().toLowerCase()) == -1) {
                if (current_location == 0) {
                    $('#modal1').modal('open');
                } else {
                    // Ajax Call to Add to database
                    $.ajax({
                        type: 'post',
                        url: $('#url_ajax').val(),
                        data: {
                            function_name: 'add_department',
                            name: $('.department_name').val(),
                            location_id: current_location,
                            '_token': $('input[name=_token]').val()
                        },
                        success: function (data) {
                            if (data.success) {
                                // Append to Department List
                                $('#department_collection').append('<li class="collection-item remove-only"><div><strong class="dept_name_check">' + $('.department_name').val() + '</strong><a href="#!" class="secondary-content"><i class="material-icons delete_dept" remove_dept=' + data.insert_id + '>cancel</i></a></li>');

                                $('.department_name').val('');

                                //Function to delete to Locations Collection
                                $(".delete_dept").click(function () {
                                    delete_department($(this));
                                });
                            }
                        }
                    });
                }
            } else {
                $('#error_msg').text('Department already Exists !');
                $('#error_modal').modal('open');
                $('.department_name').val('');
            }
        }
    });

    //Function to delete to Department Collection
    $(".delete_dept").click(function () {
        delete_department($(this));
    });

});

function delete_location(objThis) {

    var obj = objThis;

    //Ajax Call to Delete to database
    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'del_location',
            id: obj.attr('remove-id'),
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            if (data.success) {
                obj.parent().remove();
            }
        }
    })
}

function delete_department(objThis) {
    var obj = objThis;

    //Ajax Call to Delete to database
    $.ajax({
        type: 'post',
        url: $('#url_ajax').val(),
        data: {
            function_name: 'del_department',
            id: obj.attr('remove_dept'),
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            if (data.success) {
                obj.parent().parent().parent().remove();
            }
        }
    })
}
