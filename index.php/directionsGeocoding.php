<?php
//php file to geocode entered starting and ending locations
//get posted info
include 'sqlQueries.php';

if($_POST) {
    if(isset($_POST['sLocation'])) {
        $sLocation = $_POST['sLocation'];
    }
    else {
        //error coding for empty starting location
    }
    if(isset($_POST['destination'])) {
        $destination = $_POST['destination'];
    }
    else {
        //error coding for empty destination
    }
	if(isset($_POST['time'])) {
        $timeSelected = $_POST['time'];
    }
    else {
        //error coding for empty time
    }

	//parse inputs to be placed into geocoding URL
	$mapquestStartURL = "http://www.mapquestapi.com/geocoding/v1/address?key=Fmjtd%7Cluub2q01l9%2C8n%3Do5-9u70gw&inFormat=kvp&outFormat=json&location=";
	$mapURL1 = "";
	$mapURL1 .= $mapquestStartURL . $sLocation . "&thumbMaps=false&maxResults=1";
	$mapURL2 = "";
	$mapURL2 .= $mapquestStartURL . $destination . "&thumbMaps=false&maxResults=1";
	
	//$json1 = file_get_contents($mapURL1); //get json from input URL
	$json1 = curl($mapURL1); //use curl function
	$data1 = json_decode($json1); //decodes json
	
	//lng is located in results->locations->latLng->lng in the json
	$lat1=$data1->{"results"}->{"locations"}->{"latLng"}->{"lat"};
	$long1=$data1->{"results"}->{"locations"}->{"latLng"}->{"long"};
	
	//$json2 = file_get_contents($mapURL2); //get json from input URL
	$json2 = curl($mapURL2); //use curl function
	$data2 = json_decode($json2); //transforms json into array
	$lat2=$data1->{"results"}->{"locations"}->{"latLng"}->{"lat"};
	$long2=$data2->{"results"}->{"locations"}->{"latLng"}->{"long"};
	
	//after getting lat and lng for both start and destination, need to get points
	//sql query of all points inside box formed by those coords
	//need to get bounds for box
	$topLeftLat=0;
	$topLeftLong=0;
	$bottomRightLat=0;
	$bottomRightLong=0;
	if($lat1>$lat2){
		$topLeftLat=$lat1;
		$bottomRightLat=$lat2;
	}
	else{
		$topLeftLat=$lat2;
		$bottomRightLat=$lat1;
	}
	if($long1>$long2){
		$bottomRightLong=$long1;
		$topLeftLong=$long2;
	}
	else{
		$bottomRightLong=$long2;
		$topLeftLong=$long1;
	}
	
	//input those values into function so that SQL query can be made to get all locations within bounded box
	$pointsArray = array();
	$pointsArray = getPointsInBox($topLeftLat,$bottomRightLat,$topLeftLong,$bottomRightLong);
	
	//need to get route from mapquest API
	//tell it to avoid points found in query
	$directionsURL = "http://www.mapquestapi.com/directions/v1/route?key=Fmjtd%7Cluub2q01l9%2C8n%3Do5-9u70gw&ambiguities=ignore&avoidTimedConditions=false&outFormat=json&routeType=fastest&enhancedNarrative=false&shapeFormat=raw&generalize=0&locale=en_US&unit=m&from=";
	$directionsURL .= $sLocation . "&to=" . $destination;
	
	//rest of URL in the form of
	//&routeControlPoint=Lat,Long,0.1,2
	$additionalURL = "";
	foreach($pointsArray as $point){
		$additionalURL .= "&routeControlPoint=" . $point['lngLat'] . ",0.1,2";
	}
	$directionsURL .= $additionalURL;
	//get json of output of URL
	//$djson = file_get_contents($directionsURL);
	$djson = curl($directionsURL);
	$ddata = json_decode($djson);
	//get URL of displayed static map
	//if it isnt easy, can create one through getting sessionID, center of map, and correct zoom
	
	$centerLat=($lat1+$lat2)/2;
	$centerLong=($long1+$long2)/2;
	$zoom=12; //default to 12 for now (values from 1-18)
	$sessionID=$ddata->{"route"}->{"sessionId"}; //from ddata
	
	$imgURL = "http://www.mapquestapi.com/staticmap/v4/getmap?key=Fmjtd|luub2q01l9,8n=o5-9u70gw&type=map&size=600,600&center=";
	$imgURL .= $centerLat . ',' . $centerLong; //add center of map
	$imgURL .= "&zoom=" . $zoom; //add zoom value
	$imgURL .= "&session=" . $sessionID; //add sessionID value
	//can add things like markers for start and end
	
	
	//set up curl function for use
	//use instead of file_get_contents($url)
	function curl($url){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
	
}

?>
<img id='mapImg' src= '<?php echo $imgURL ?>' alt='Map Image of Directions'>

