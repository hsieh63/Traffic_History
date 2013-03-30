<?php include 'header.php'; ?>
<script>
$(document).ready(function() {
    $('#mapImageData').submit(function() {
        //alert($('#mapImageData').serialize());
        $.ajax({
            url: "mapImaging.php",
            type: "POST",
            data: $('#mapImageData').serialize(),
            success: function(response) {
                $('#mapImageData').find('#formResult').html(response);
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
    <div align="center">
        Under construction
        <br>
        Testing
        <br>
        <form id="mapImageData" action="" method="">
        Zipcode: <input type="number" name="zipcode">
        <input type="submit" value="Submit">
        <div id="formResult"> </div>
        </form>
    </div>
<?php include 'footer.php'; ?>
