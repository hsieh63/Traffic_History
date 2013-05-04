<?php include 'header.php'; ?>
<script>
$(document).ready(function() {
$('#directionsImageData').submit(function() {
        //alert($('#mapImageData').serialize());
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
        return false;
    });
});
</script>
<!--
 <script>
$(document).ready(function() {
    $("#startLoc").autocomplete({
        source: function( request, response ) {
            var options = {
              types: ['geocode'],
              componentRestrictions: {country: 'us'}
            };
            autocomplete = new google.maps.places.Autocomplete(request.term, options);
            alert(autocomplete.getPlace());
        },
        minlength: 2
        });
});
</script>
-->

 <div align="center">
	Directions Service
	<br>
	Testing
	<br>
	<form id="directionsImageData" action="" method="">
	Starting Location: <input type="text" name="sLocation" id="startLoc">
	Destination: <input type="text" name="destination" id="endLoc">
	<select name="time" required>
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
	<input type="submit" value="Submit">
	<div id="formResult"> </div>
    </form>

</div>

<?php include 'footer.php'; ?>
