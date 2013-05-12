<?php
//written by: John Reed
//tested by: John Reed
//debugged by: Kevin Hsieh and John Reed
?>
<?php include 'header.php'; ?>
<script>
$(document).ready(function() {
    $('#directionsImageData').validate({
        rules: {
            sLocation : "required",
            destination : "required",
            time : "required"
        },
        messages: {
            sLocation : "Please enter a start location.",
            destination : "Please enter a destination.",
            time : "Please select a time"
        },
        submitHandler: function(form) {
            $.ajax({
                url: "directionsGeocoding.php",
                type: "POST",
                data: $('#directionsImageData').serialize(),
                success: function(response) {
                    //$('#intensityColorTble').show();
                    $('#directionsImageData').find('#formResult').html(response);
                    //alert('Success');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //alert('Error');
                }
            });
        },
        invalidHandler: function(event, validator) {
            return false;
        }
    });
    
    var startBox = (document.getElementById('startLoc'));
    var options = {
        types: ['geocode'],
        componentRestrictions: {country: 'us'}
    };
    var startAutocomplete = new google.maps.places.Autocomplete(startBox, options);

    google.maps.event.addListener(startAutocomplete, 'place_changed', function() {
        var place = startAutocomplete.getPlace();
        console.log(place.address_components);
    });
    
    var endBox = (document.getElementById('endLoc'));
    var endAutocomplete = new google.maps.places.Autocomplete(endBox, options);

    google.maps.event.addListener(endAutocomplete, 'place_changed', function() {
        var place = endAutocomplete.getPlace();
        console.log(place.address_components);
    });
});
</script>
<script>
$(document).ready(function() {
    function GetQueryStringParams(sParam)
    {
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) 
        {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam) 
            {
                return sParameterName[1];
            }
        }
    }
    if (GetQueryStringParams('amount') == 3) {
        $.ajax({
            url: "directionsGeocoding.php",
            type: "POST",
            data: {sLocation : GetQueryStringParams('sLocation'), destination : GetQueryStringParams('destination'),time : GetQueryStringParams('time')},
            success: function(response) {
                //$('#intensityColorTble').show();
                $('#directionsImageData').find('#formResult').html(response);
                //alert('Success');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                //alert('Error');
            }
        });
    }

});
</script>

 <div align="center">
	Directions Service
	<br>
	Testing
	<br>
	<form id="directionsImageData" action="" method="">
        <table>
            <tr>
                <td>
	                Starting Location: <input type="text" name="sLocation" id="startLoc" size = "50">
                </td>
                <td>
	                Destination: <input type="text" name="destination" id="endLoc" size = "50">
                </td>
                <td>
	                <select name="time">
                            <option value="-1" selected="selected" disabled>Estimated Leaving Time:</option>
                            <option value="0">12am-3am</option>
                            <option value="1">3am-6am</option>
                            <option value="2">6am-9am</option>
                            <option value="3">9am-12pm</option>
                            <option value="4">12am-3pm</option>
                            <option value="5">3pm-6pm</option>
                            <option value="6">6pm-9pm</option>
                            <option value="7">9pm-12am</option>
                    </select>
                </td>
                <td>
	                <input type="submit" value="Submit">
                </td>
            </tr>
            <tr>
                <td>
                    <label class="error" for="startLoc" style="color:#FF0000;"></label>
                </td>
                <td>
                    <label class="error" for="endLoc" style="color:#FF0000;"></label>
                </td>
                <td>
                    <label class="error" for="time" style="color:#FF0000;"></label>
                </td>
                <td>
                </td>
            </tr>
        </table>
	<div id="formResult"> </div>
    </form>

</div>

<?php include 'footer.php'; ?>
