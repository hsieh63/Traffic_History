<?php include 'header.php'; ?>
<script>
//use javscript validation to check if all inputs filled out
$(document).ready(function() {
    $('#zoomIn').hide();
    $('#zoomOut').hide();
    $('#mapImageData').submit(function() {
        //alert($('#mapImageData').serialize());
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
        return false;
    });
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
        Zipcode: <input type="number" name="zipcode">
        <select name="time" required>
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
        <select name="weather" required>
            <option value="-1" selected="selected" disabled>Select weather condition</option>
            <option value="sunny">Sunny</option>
            <option value="rainy">Rainy</option>
            <option value="cloudy">Cloudy</option>
            <option value="clear">Clear</option>
        </select>
        <input type="submit" value="Submit">
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
    </div>
<?php include 'footer.php'; ?>
