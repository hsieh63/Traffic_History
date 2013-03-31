<?php
//need to build in error conditions for fields not selected or properly filled out
//also need sql sanitation
//include 'sqlQueries.php';
if(isset($_POST['zipcode'])) {
    $zipcode = $_POST['zipcode'];
    //mapTrafficPoints();
    //key: AIzaSyAdM76kzhZ0uwCyHxZLogbt5Sc9PrF1RpM
    //linkg: http://maps.googleapis.com/maps/api/staticmap?center=New+York,NY&zoom=13&size=600x300&key=API_console_key
    $googleImgSrc = "http://maps.googleapis.com/maps/api/staticmap?center=" . $zipcode . "&zoom=10&size=640x640&scale=2&key=AIzaSyAdM76kzhZ0uwCyHxZLogbt5Sc9PrF1RpM&sensor=false";
    //can either echo or just construct it in html
    //$htmlImg = "<img id='mapImg' src= '" . $googleImgSrc . "' alt='Map Image of " . $zipcode . "'><label id='zoomLvl' value='10' style='display:none;'></label>";
    //echo $htmlImg;
}
?>
<img id='mapImg' src= '<?php echo $googleImgSrc ?>' alt='Map Image of <?php echo $zipcode ?>'><label id='zoomLvl' value='10' style='display:none;'></label>";