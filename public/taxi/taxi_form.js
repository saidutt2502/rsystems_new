$(document).ready(function(){
    $('#trip_type').change(function(){
        $('.remove').remove();
        if($('#trip_type').val()=='Airport')
        {
            $.ajax({
                type: 'post',
                url: $('#url_ajax').val(),
                data: {
                    function_name: 'get_airports',
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                    if(data.count>1)
                    {

                        $('#add_form').append('<div class="remove"><div class="form-group"><br><label class="col-sm-3 control-label no-padding-right" >Place</label><div class="col-sm-4"><select id="airport_locations"  name="place" class="chosen-container chosen-container-single chosen-select"  required><option value="" disabled selected>Select Place</option></select></div></div><div class="form-group"><div class="col-sm-offset-3 col-sm-6"><input type="radio" name="journey" value="Drop" checked> Airport Drop</input></div><div class="col-sm-offset-3 col-sm-6"><input type="radio" name="journey" value="Pick"> Airport Pickup</input></div></div><div class="form-group"><label class="col-sm-3 control-label no-padding-right">Time</label><div class="col-sm-9"><input name="time" class="col-xs-10 col-sm-5" type="time" required></div></div></div>');
                        for(var i=0;i<data.count-1;i++)
                        {
                            $('#airport_locations').append('<option value="'+data[i]+'">'+data[i]+'</option>');
                        }
                        
                    }
                    else
                    {
                        $('#add_form').append('<div class="remove"><div class="form-group"><label class="col-sm-3 control-label no-padding-right">Place</label><div class="col-sm-9"><input name="place" class="col-xs-10 col-sm-5" type="text" required></div></div><div class="form-group"><div class="col-sm-offset-3 col-sm-6"><input type="radio" name="journey" value="Drop" checked> Airport Drop</input></div><div class="col-sm-offset-3 col-sm-6"><input type="radio" name="journey" value="Pick"> Airport Pickup</input></div></div><div class="form-group"><label class="col-sm-3 control-label no-padding-right">Time</label><div class="col-sm-9"><input name="time" class="col-xs-10 col-sm-5" type="time" required></div></div></div>');
                    }
                }
            });
            
        }
        else if($('#trip_type').val()=='Local Run')
        {
            $('#add_form').append('<div class="remove"><div class="form-group"><label class="col-sm-3 control-label no-padding-right">Place (From)</label><div class="col-sm-9"><input name="place_from" class="col-xs-10 col-sm-5" type="text" required></div></div><div class="form-group"><label class="col-sm-3 control-label no-padding-right">Place (To)</label><div class="col-sm-9"><input name="place_to" class="col-xs-10 col-sm-5" type="text" required></div></div><div class="form-group"><label class="col-sm-3 control-label no-padding-right">Departure (Place 1)</label><div class="col-sm-9"><input name="from_time" class="col-xs-10 col-sm-5" type="time" required></div></div><div class="form-group"><label class="col-sm-3 control-label no-padding-right">Departure (Place 2)</label><div class="col-sm-9"><input name="to_time" class="col-xs-10 col-sm-5" type="time"><br><br>*Leave empty if this is not a return trip.</div></div></div>');
        }
    });
    
    $('#reset').click(function(){
        $('.remove').remove();
    }); 
});     

