
$(document).ready(function () {

    $('.show-details-btn').on('click', function(e) {
        e.preventDefault();
        $(this).closest('tr').next().toggleClass('open');
        $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
    });


    //Function to append to Locations Collection
    $("#add_location_ico").click(function () {

        if ($('#location_name').val() != '') {
                // Ajax Call to Add to database
                $.ajax({
                    type: 'post',
                    url: $('#url_ajax').val(),
                    data: {
                        function_name: 'add_location',
                        name: $('#location_name').val(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        if (data.success) {
                            location.reload();
                        }
                    }
                })
        }
    });

    //Function to delete to location
    $(".delete_location").click(function () {
        var id = $(this).attr('data-location-id');
        $("#myModal").modal();
        $("#confirm_delete").click(function () {
            //Ajax Call to Delete to database
                $.ajax({
                    type: 'post',
                    url: $('#url_ajax').val(),
                    data: {
                        function_name: 'del_location',
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

    //Function  to add Department
    $(".add_department_ico").click(function () {
        var loc_id = $(this).attr('data-location');
        var name = $("[input-id="+loc_id+"]").val();

            // Ajax Call to Add to database
            $.ajax({
                type: 'post',
                url: $('#url_ajax').val(),
                data: {
                    function_name: 'add_department',
                    name: name,
                    location_id: loc_id,
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                    if (data.success) {
                        // Append to Department List
                        location.reload();
                    }
                }
            });
    });

    //Function to delete Department 
    $(".delete_dept").click(function () {
         //Ajax Call to Delete to database
            $.ajax({
                type: 'post',
                url: $('#url_ajax').val(),
                data: {
                    function_name: 'del_department',
                    id: $(this).attr('dept-id'),
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


