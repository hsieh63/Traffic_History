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
                $('#zoomIn').show();
                $('#zoomOut').show();
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
        var imgSrc = $('mapImg').attr('src');
        var zoomLvl = $('zoomLvl').attr('value');
        zoomLvl = zoomLvl + 1;
        imgSrc = imgSrc.replace('zoom=[0-9]+','zoom=' + zoomLvl);
        $('mapImg').attr('src') = imgSrc;
    });
    $('#zoomOut').click(function () {
        var imgSrc = $('mapImg').attr('src');
        var zoom = $('zoomLvl').attr('value');
        zoom = zoom - 1;
        imgSrc = imgSrc.replace('zoom=[0-9]+','zoom=' + zoomLvl);
        $('mapImg').attr('src') = imgSrc;
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
        <input type="submit" value="Submit">
        <br>
        <button id="zoomIn" type="button" style="display: none;">Zoom In</button>
        <button id="zoomOut" type="button" style="display: none;">Zoom Out</button>
        <div id="formResult"> </div>
        </form>
    </div>
<?php include 'footer.php'; ?>
