<?php include 'header.php'; ?>
<script>
$('#mapImageData').submit(function() {
    $.ajax({
        url: "mapImaging.php",
        type: "POST"
        data: $('#mapImageData').serialize(),
        success: function(response) {
            $('#formResult').html(response);
        }
    });
    return false;
});
</script>
    <div align="center">
        Under construction
        <br>
        Testing
        <br>
        <form id="mapImageData" action="mapImaging.php" method="post">
        Zipcode: <input type="number" name="zipcode">
        <input type="submit" value="Submit">
        </form>
    </div>
    <div id="formResult"> </div>
<?php include 'footer.php'; ?>
