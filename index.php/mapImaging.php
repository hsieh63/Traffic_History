<?php
//include 'sqlQueries.php';
$zipcode = $_POST["zipcode"];
//mapTrafficPoints();
//key: AIzaSyAdM76kzhZ0uwCyHxZLogbt5Sc9PrF1RpM
//linkg: http://maps.googleapis.com/maps/api/staticmap?center=New+York,NY&zoom=13&size=600x300&key=API_console_key
$googleImgSrc = "http://maps.googleapis.com/maps/api/staticmap?center=" . $zipcode . "&zoom=10&size=640x640&scale=2&key=AIzaSyAdM76kzhZ0uwCyHxZLogbt5Sc9PrF1RpM&sensor=false";
$htmlImg = "<img src= '" . $googleImgSrc . "' alt='Map Image of " . $zipcode . "'>";
echo $htmlImg;
?>

//<?php include 'header.php'; ?>
//    <div align="center">
//    Testing
//    <br>
//        <img src="<?php echo $googleImgSrc; ?>" alt="Map Image of <?php echo $zipcode; ?>">
//    </div>
//<?php include 'footer.php'; ?>