﻿<?php include 'header.php'; ?>
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
    }​
    if (GetQueryStringParams('amount') == 3) {
        $.ajax({
                url: "mapImaging.php",
                type: "POST",
                data: {zipcode : GetQueryStringParams('zipcode'), time : GetQueryStringParams('time'),weather : GetQueryStringParams('weather')},
                success: function(response) {
                    //$('#zoomIn').show();
                    //$('#zoomOut').show();
                    $('#intensityColorTble').show();
                    $('#mapImageData').find('#formResult').html(response);
                    //alert('Success');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //alert('Error');
                }
            });
    }
    $('#mapImageData').validate({
        rules: {
            zipcode: {
                required: true,
                minlength: 5,
                maxlength: 5,
                digits: true
            },
            time : "required",
            weather : "required"
        },
        messages: {
            zipcode: {
                required: "Please input a zipcode",
                minlength: "Zipcode must be 5 digits",
                maxlength: "Zipcode must be 5 digits",
                digits: "Zipcode must be digits"
            },
            time : "Please select a time",
            weather : "Please select a weather condition."
        },
        submitHandler: function(form) {
            $.ajax({
                url: "mapImaging.php",
                type: "POST",
                data: $('#mapImageData').serialize(),
                success: function(response) {
                    //$('#zoomIn').show();
                    //$('#zoomOut').show();
                    $('#intensityColorTble').show();
                    $('#mapImageData').find('#formResult').html(response);
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
    $('#zoomIn').hide();
    $('#zoomOut').hide();
    $('#zoomIn').click(function () {
        var imgSrc = $('#mapImg').attr('src');
        var zoomLvlSt = $('#zoomLvl').attr('value');
        var zoomLvl = parseInt(zoomLvlSt);
        zoomLvl = zoomLvl + 1;
        var newSrc = 'zoom=' + zoomLvl;
        imgSrc = imgSrc.replace(/zoom=\d+/g,newSrc);
        $('#mapImg').attr('src', imgSrc);
        $('#zoomLvl').attr('value',zoomLvl);
    });
    $('#zoomOut').click(function () {
        var imgSrc = $('#mapImg').attr('src');
        var zoomLvlSt = $('#zoomLvl').attr('value');
        var zoomLvl = parseInt(zoomLvlSt);
        zoomLvl = zoomLvl - 1;
        var newSrc = 'zoom=' + zoomLvl;
        imgSrc = imgSrc.replace(/zoom=\d+/g,newSrc);
        $('#mapImg').attr('src', imgSrc);
        $('#zoomLvl').attr('value',zoomLvl);
    });
});
</script>
    <div align="center">
        Under construction
        <br>
        Testing
        <br>
        <form id="mapImageData" action="" method="">
        <table>
            <tr>
                <td>
                    Zipcode: <input name="zipcode" id="zipcode">
                </td>
                <td>
                    <select name="time">
                        <option value="-1" selected="selected" disabled>Select a time period</option>
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
                    <select name="weather">
                        <option value="-1" selected="selected" disabled>Select weather condition</option>
                        <option value="sunny">Sunny</option>
                        <option value="rain">Rainy</option>
                        <option value="cloudy">Cloudy</option>
                        <option value="sleet">Sleet</option>
                        <option value="snow">Snow</option>
                        <option value="tstorms">Thunder Storms</option>
                        <option value="unknown">Unkown</option>
                    </select>
                </td>
                <td>
                    <input type="submit" value="Submit" id="submitInput">
                </td>
            </tr>
            <tr>
                <td>
                    <label class="error" for="zipcode" style="color:#FF0000;"></label>
                </td>
                <td>
                    <label class="error" for="time" style="color:#FF0000;"></label>
                </td>
                <td>
                    <label class="error" for="weather" style="color:#FF0000;"></label>
                </td>
                <td>
                </td>
            </tr>
        </table>
        <br>
        <button id="zoomIn" type="button" style="display: none;">Zoom In</button>
        <button id="zoomOut" type="button" style="display: none;">Zoom Out</button>
        <br>
        <table id="intensityColorTble" style="text-align:center;display: none;">
            <tr>
                <td colspan=5>
                    Severity color correspondence (low to high)
                </td>
            </tr>
            <tr>
                <td>
                    <label style="background-color:#00FF00;">Severity : 1 (lowest)</label>
                </td>
                <td>
                    <label style="background-color:#CCFF00;">Severity : 2 (lower)</label>
                </td>
                <td>
                    <label style="background-color:#FFFF00;">Severity : 3 (medium)</label>
                </td>
                <td>
                    <label style="background-color:#FF9900;">Severity : 4 (higher)</label>
                </td>
                <td>
                    <label style="background-color:#FF0000;">Severity : 5 (highest)</label>
                </td>
            </tr>
        </table>
        <br>
        <div id="formResult"> </div>
        </form>

<?php /* //if logged in, display recent searches 

	session_start();
	
	if ($_SESSION['loggedin'] == TRUE) { 
	
		$username = $_SESSION['username'];
		
		//Create database connection
		$con = mysqli_connect("localhost","traffich_admin","Admin2013","traffich_main");
				
		//Display error message if connection fails
		if (mysqli_connect_errno($con))	{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
				
		$query = "SELECT recentMap
				  FROM Login 
				  WHERE Username = '$username'";
				  
		//Obtain the result of the query
		$result = $con->query($query);

		//Get the first (and only) row of the result		
		$row = $result->fetch_row();

		if($row[0] != NULL) {
			$recentMap = $row[0];
			
			//Turn the string into an array, with delimeter ','
			$recentArray = explode(',', $recentMap);
			//Find the size of the array
			$size = count($recentArray);
			
			echo "<h3>Recent Searches</h3>";
			echo "1.) Zip Code: $recentArray[0] Time Period: $recentArray[1] Weather: $recentArray[2]"; ?>
				 <form id="mapImageData" action="" method="">
				 <input type = "hidden" name = "zipcode" id="zipcode" value = <?php echo "$recentArray[0]"; ?>>
				 <input type = "hidden" name = "time" value = <?php echo "$recentArray[1]"; ?>>
				 <input type = "hidden" name = "weather" value = <?php echo "$recentArray[2]"; ?>>
				 <input type = "submit" value="Submit" id="submitInput">
				 </form> <?php
			if(isset($recentArray[4])) {
				echo "2.) Zip Code: $recentArray[3] Time Period: $recentArray[4] Weather: $recentArray[5]"; ?>
				 <form id="mapImageData" action="" method="">
				 <input type = "hidden" name = "zipcode" id="zipcode" value = <?php echo "$recentArray[3]"; ?>>
				 <input type = "hidden" name = "time" value = <?php echo "$recentArray[4]"; ?>>
				 <input type = "hidden" name = "weather" value = <?php echo "$recentArray[5]"; ?>>
				 <input type = "submit" value="Submit" id="submitInput">
				 </form> <?php
			}
			if(isset($recentArray[7])) {
				echo "3.) Zip Code: $recentArray[6] Time Period: $recentArray[7] Weather: $recentArray[8]"; ?>
				 <form id="mapImageData" action="" method="">
				 <input type = "hidden" name = "zipcode" id="zipcode" value = <?php echo "$recentArray[6]"; ?>>
				 <input type = "hidden" name = "time" value = <?php echo "$recentArray[7]"; ?>>
				 <input type = "hidden" name = "weather" value = <?php echo "$recentArray[8]"; ?>>
				 <input type = "submit" value="Submit" id="submitInput">
				 </form> <?php
			}
			if(isset($recentArray[10])) {
				echo "4.) Zip Code: $recentArray[9] Time Period: $recentArray[10] Weather: $recentArray[11]"; ?>
				 <form id="mapImageData" action="" method="">
				 <input type = "hidden" name = "zipcode" id="zipcode" value = <?php echo "$recentArray[9]"; ?>>
				 <input type = "hidden" name = "time" value = <?php echo "$recentArray[10]"; ?>>
				 <input type = "hidden" name = "weather" value = <?php echo "$recentArray[11]"; ?>>
				 <input type = "submit" value="Submit" id="submitInput">
				 </form> <?php
			}
			if(isset($recentArray[13])) {
				echo "5.) Zip Code: $recentArray[12] Time Period: $recentArray[13] Weather: $recentArray[14]"; ?>
				 <form id="mapImageData" action="" method="">
				 <input type = "hidden" name = "zipcode" id="zipcode" value = <?php echo "$recentArray[12]"; ?>>
				 <input type = "hidden" name = "time" value = <?php echo "$recentArray[13]"; ?>>
				 <input type = "hidden" name = "weather" value = <?php echo "$recentArray[14]"; ?>>
				 <input type = "submit" value="Submit" id="submitInput">
				 </form> <?php
			}
			
		}

	} */
?> 
    </div>
<?php include 'footer.php'; ?>
