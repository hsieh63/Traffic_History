<?php
//need to build in error conditions for fields not selected or properly filled out
//also need sql sanitation
//include 'sqlQueries.php';
if($_POST) {
    if(isset($_POST['zipcode'])) {
        $zipcode = $_POST['zipcode'];
    }
    else {
        //error coding for empty zipcode
    }
    if(isset($_POST['time'])) {
        $timeSelected = $_POST['time'];
    }
    else {
        //error coding for empty time
    }
    /*
    if(isset($_POST['weather'])) {
        $weatherSelected = $_POST['weather'];
    }
    else {
        //error coding for empty time
    }
    */
    //mapTrafficPoints($zipcode, $timeSelected, $weatherSelected);
    
    //for google
    //key: AIzaSyAdM76kzhZ0uwCyHxZLogbt5Sc9PrF1RpM
    //linkg: http://maps.googleapis.com/maps/api/staticmap?center=New+York,NY&zoom=13&size=600x300&key=API_console_key
    $googleImgSrc = "http://maps.googleapis.com/maps/api/staticmap?center=" . $zipcode . "&zoom=10&size=640x640&scale=2&key=AIzaSyAdM76kzhZ0uwCyHxZLogbt5Sc9PrF1RpM&sensor=false";
    //can either echo or just construct it in html
    //$htmlImg = "<img id='mapImg' src= '" . $googleImgSrc . "' alt='Map Image of " . $zipcode . "'><label id='zoomLvl' value='10' style='display:none;'></label>";
    //echo $htmlImg;
    //for mapquest
    //key: Fmjtd%7Cluub2168nu%2Cax%3Do5-96zg9u
    //http://www.mapquestapi.com/staticmap/v4/getmap?key=YOUR_KEY_HERE&center=40.044600,-76.413100&zoom=10&size=400,200&type=map&imagetype=jpeg&pois=1,40.098579,-76.398703,-20,-20|orange-100,40.069116,-76.401178|green,40.098088,-76.346092|yellow-s,40.069607,-76.352282
    //http://www.mapquestapi.com/staticmap/v4/getmap?key=Fmjtd%7Cluub2168nu%2Cax%3Do5-96zg9u&location= zipcode &size=640,640&zoom=&scale=
}
?>
<img id='mapImg' src= '<?php echo $googleImgSrc ?>' alt='Map Image of <?php echo $zipcode ?>'><label id='zoomLvl' value='10' style='display:none;'></label>