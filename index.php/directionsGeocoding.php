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

	//IF LOGGED IN, ENTER THEIR NEW SEARCH IN MOST RECENT SEARCHES
	
	//function which can move elements of an array
	function moveValueByIndex( array $array, $from=null, $to=null )
	{
		if ( null === $from )
	{
		$from = count( $array ) - 1;
	}

	if ( !isset( $array[$from] ) )
	{
		throw new Exception( "Offset $from does not exist" );
	}

	if ( array_keys( $array ) != range( 0, count( $array ) - 1 ) )
	{
		throw new Exception( "Invalid array keys" );
	}

	$value = $array[$from];
	unset( $array[$from] );
	
	if ( null === $to )
	{
		array_push( $array, $value );
	} else {
		$tail = array_splice( $array, $to );
		array_push( $array, $value );
		$array = array_merge( $array, $tail );
	}

	return $array;
	}
	
	//function which determines whether an array is located within another array (consecutively)
	function consecutive_values(array $needle, array $haystack) {
		$i_max = count($haystack)-count($needle) + 1;
		$j_max = count($needle);
		for($i=0; $i<$i_max; ++$i) {
			$match = true;
			for($j=0; $j<$j_max; ++$j) {
				if($needle[$j]!=$haystack[$i+$j]) {
					$match = false;
					break;
				}
			}
			if($match) {
				return $i;
			}
		}
		return -1;
	}

	session_start();
	
	if ($_SESSION['loggedin'] == TRUE) { 
		
		$username = $_SESSION['username'];
		
		//Create database connection
		$con = mysqli_connect("localhost","traffich_admin","Admin2013","traffich_main");
				
		//Display error message if connection fails
		if (mysqli_connect_errno($con))	{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
				
		$query = "SELECT recentDirections
				  FROM Login 
				  WHERE Username = '$username'";
				  
		//Obtain the result of the query
		$result = $con->query($query);

		//Get the first (and only) row of the result		
		$row = $result->fetch_row();
		
		//Convert most recent search into an array
		$mostRecent = array($sLocation, $destination, $timeSelected);
		
		//Obtain the recent directions searches string
		$recentString = $row[0];
		
		//Turn the string into an array, with delimeter ','
		$recentArray = explode(':', $recentString);
		//Find the size of the array
		$size = count($recentArray);
		
		//Check the array for the most recent search
	
		$needle = $mostRecent;
		$haystack = $recentArray;
		
		$searchExists = consecutive_values($needle, $haystack);		
		$newRecent = $recentArray;
		
		//If the search already exists, move it to the front of the array
		//Move the two elements to the front
		if($searchExists >= 0) {
		//	echo "That search exists already";
			$newRecent = moveValueByIndex($newRecent, $searchExists+2, 0);
			$newRecent = moveValueByIndex($newRecent, $searchExists+2, 0);
			$newRecent = moveValueByIndex($newRecent, $searchExists+2, 0);
		}
		else if ($size < 15) { //if the array doesn't contain 5 searches, just add the most recent to the beginning
		//	echo "There are less than 5 searches<br>";
			array_unshift($newRecent, $mostRecent[0], $mostRecent[1], $mostRecent[2]);
		}
		else{ //if the array has 5 searches, get rid of the last one (last three elements) and add the new one to the beginning
		//	echo "There are 15 searches.  Removing last recent search.";zzz
			array_pop($newRecent);
			array_pop($newRecent);
			array_pop($newRecent);

			array_unshift($newRecent, $mostRecent[0], $mostRecent[1], $mostRecent[2]);
		}
			
		//Convert the new array into a string, and change the recentMap string in the database to the new one
		
		$newRecentString = implode(":", $newRecent);
		//echo "<br> New string: $newRecentString <br>";
		

		$sql = "UPDATE Login 
				  SET recentDirections = '$newRecentString'
				  WHERE Username = '$username'";

		$query = mysqli_query($con, $sql);
		if (!$query) {
			echo "Query failed<br><br>";
		}
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
	$lat2=$data2->{"results"}[0]->{"locations"}[0]->{"latLng"}->{"lat"};
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
	$sessionID=$ddata->{"route"}->{"sessionId"}; //from ddata
    //echo "<br>$sessionID<br><br>";
    
	//getting correct zoom value
	$zoom=0;
	$distanceZ=1;
	$distanceZ = $ddata->{"route"}->{"distance"};
	$distanceZ = $distanceZ*5280; //get total distance into feet
	if($distanceZ<6770) $zoom=15;
	else if($distanceZ<13541) $zoom=14;
	else if($distanceZ<27083) $zoom=13;
	else if($distanceZ<54167) $zoom=12;
	else if($distanceZ<108335) $zoom=11;
	else if($distanceZ>=108335) {$zoom=10; echo "Results may be inaccurrate, route too large to accurately use all traffic points.<br>";}
	else $zoom=13; //default zoom value
	
    //use a foreach loop to go through all maneuvers and collect all the narratives
	echo "<table border=\"1\" bgcolor=\"#ffffff\"><tr><th>Maneuver</th><th>Distance</th></tr>";
	$counter=0;
	foreach($ddata->{"route"}->{"legs"}[0]->{"maneuvers"} as $maneuvers){
	$narrative = $ddata->{"route"}->{"legs"}[0]->{"maneuvers"}[$counter]->{"narrative"};
	$distance = $ddata->{"route"}->{"legs"}[0]->{"maneuvers"}[$counter]->{"distance"};
	echo "<tr><td>" . $narrative . "</td><td>" . $distance . " miles</td></tr>";
	$counter=$counter+1;
	}
	echo "</table>";
	
	//output total distance and estimated time
	$totalTime=$ddata->{"route"}->{"time"};
	$hours=floor($totalTime/3600);
	$minutes=floor(($totalTime - ($hours*3600))/60);
	$seconds=$totalTime%60;
	$totalDistance = $ddata->{"route"}->{"distance"};
	echo "<b>Total Distance: </b> " . $totalDistance . " Miles.<BR>";
	echo "<b>Estimated Time:</b> " . $hours . " Hours, " . $minutes . " Minutes, " . $seconds . " Seconds.<BR>";
	
	$imgURL = "http://www.mapquestapi.com/staticmap/v4/getmap?key=Fmjtd|luub2q01l9,8n=o5-9u70gw&type=map&size=600,600";
	//&pois=purple-A,40.037822,-76.305679,0,0|purple-B,40.039539,-76.305976,0,0|
	$imgURL .= "&pois=purple-A," . $lat1 . ',' . $long1 . ",0,0|purple-B," . $lat2 . ',' . $long2 . ",0,0|";
	$imgURL .= "&center=" . $centerLat . ',' . $centerLong; //add center of map
	$imgURL .= "&zoom=" . $zoom; //add zoom value
	$imgURL .= "&session=" . $sessionID; //add sessionID value
	
}

?>
<img id='mapImg' src= '<?php echo $imgURL ?>' alt='Map Image of Directions'>
