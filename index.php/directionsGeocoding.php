<?php
//php file to geocode entered starting and ending locations
//get posted info
include 'sqlQueries.php';

if($_POST) {
    if(isset($_POST['sLocation'])) {
        $sLocation = $_POST['sLocation'];
        $sLocation = str_replace(' ','',$sLocation);
    }
    else {
        //error coding for empty starting location
    }
    if(isset($_POST['destination'])) {
        $destination = $_POST['destination'];
        $destination = str_replace(' ','',$destination);
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

	//set up curl function for use
	//use instead of file_get_contents($url)
	function curl($url){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
            $data = curl_exec($ch);
            $data = trim($data);
			/*
			if(curl_exec($ch) === false)
			{
				echo 'Curl error: ' . curl_error($ch);
			}
			else
			{
				echo 'Operation completed without any errors <br>';
			}
			*/
			echo curl_error($ch) . "<br>";
            curl_close($ch);
            return $data;
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
    if($data1->{"info"}->{"statuscode"} != 0 ) {
        echo "$mapURL1: Not found<br>";
        exit;
    }
	$lat1=$data1->{"results"}[0]->{"locations"}[0]->{"latLng"}->{"lat"};
	$long1=$data1->{"results"}[0]->{"locations"}[0]->{"latLng"}->{"lng"};
	
	//$json2 = file_get_contents($mapURL2); //get json from input URL
	$json2 = curl($mapURL2); //use curl function
	$data2 = json_decode($json2); //transforms json into array
    if($data2->{"info"}->{"statuscode"} != 0 ) {
        echo "$mapURL2: Not found<br>";
        exit;
    }
	$lat2=$data1->{"results"}[0]->{"locations"}[0]->{"latLng"}->{"lat"};
	$long2=$data2->{"results"}[0]->{"locations"}[0]->{"latLng"}->{"lng"};
	
	//$long2=5;
	
	//testing data
	//working:
	//echo "$sLocation, $destination \n";
	//echo "$mapURL1 <br> $mapURL2 <br>";
	//echo "$json1 <br>$json2<br>Lat: $lat1 <br>Long: $long1<br/>Lat2: $lat2 <br>Long2: $long2<br>"; 
	
	
	//not working:
	//echo "Latitude 1: $lat1 Longitude 1: $long1 \n";
	//echo "Latitude 2: $lat2 Longitude 2: $long2 \n";
	
	
	
	
	
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
    if($ddata->{"info"}->{"statuscode"} != 0 ) {
        echo "Route not found<br>";
        exit;
    }
    //echo "<br>URL: $directionsURL<br><br><br>JSON Directions : $djson <br><br>";
	//get URL of displayed static map
	//if it isnt easy, can create one through getting sessionID, center of map, and correct zoom
	
	$centerLat=($lat1+$lat2)/2;
	$centerLong=($long1+$long2)/2;
	$zoom=12; //default to 12 for now (values from 1-18)
	$sessionID=$ddata->{"route"}->{"sessionId"}; //from ddata
    //echo "<br>$sessionID<br><br>";
    
    //use a foreach loop to go through all maneuvers and collect all the narratives
    $narrative = $ddata->{"route"}->{"legs"}[0]->{"maneuvers"}[0]->{"narrative"};
    $narrativetwo = $ddata->{"route"}->{"legs"}[0]->{"maneuvers"}[1]->{"narrative"};
    //echo "<br>n1: $narrative <br>n2: $narrativetwo <br>";
	
	$imgURL = "http://www.mapquestapi.com/staticmap/v4/getmap?key=Fmjtd|luub2q01l9,8n=o5-9u70gw&type=map&size=600,600&center=";
	$imgURL .= $centerLat . ',' . $centerLong; //add center of map
	$imgURL .= "&zoom=" . $zoom; //add zoom value
	$imgURL .= "&session=" . $sessionID; //add sessionID value
	//can add things like markers for start and end
	
	
	
	
}

?>
<img id='mapImg' src= '<?php echo $imgURL ?>' alt='Map Image of Directions'>

