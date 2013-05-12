<?php
//written by: Kevin Hsieh
//tested by: Kevin Hsieh
//debugged by: Kevin Hsieh
?>
<?php
/*
    PHP file to construct traffic map image
*/
//need to build in error conditions for fields not selected or properly filled out
//also need sql sanitation
include 'sqlQueries.php';
//include 'polyEncode.php';
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
    if(isset($_POST['weather'])) {
        $weatherSelected = $_POST['weather'];
    }
    else {
        //error coding for empty time
    }
	
	//IF LOGGED IN, ENTER THEIR NEW SEARCH IN MOST RECENT SEARCHES
	
	//function which can move elements of an array
	function moveValueByIndex( array $array, $from=null, $to=null )
	{
	
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
				
		$query = "SELECT recentMap
				  FROM Login 
				  WHERE Username = '$username'";
				  
		//Obtain the result of the query
		$result = $con->query($query);

		//Get the first (and only) row of the result		
		$row = $result->fetch_row();
		
		//Convert most recent search into an array
		$mostRecent = array($zipcode, $timeSelected, $weatherSelected);
		
		//Obtain the recent map searches string
		$recentString = $row[0];
		
		//Turn the string into an array, with delimeter ','
		$recentArray = explode(',', $recentString);
		//Find the size of the array
		$size = count($recentArray);
		
		//Check the array for the most recent search
	
		$needle = $mostRecent;
		$haystack = $recentArray;

		
		$searchExists = consecutive_values($needle, $haystack);		
		$newRecent = $recentArray;
		
		echo $searchExists;
		
		//If the search already exists, move it to the front of the array
		//Move the three elements to the front
		if($searchExists >= 0) {
		//	echo "That search exists already";
			$newRecent = moveValueByIndex($newRecent, $searchExists+2, 0);
			$newRecent = moveValueByIndex($newRecent, $searchExists+2, 0);
			$newRecent = moveValueByIndex($newRecent, $searchExists+2, 0);
		}
		else if ($size < 15) { //if the array doesn't contain 5 searches, just add the most recent to the beginning
		//	echo "There are less than 15 searches<br>";
			array_unshift($newRecent, $mostRecent[0], $mostRecent[1], $mostRecent[2]);
		}
		else{ //if the array has 5 searches, get rid of the last one (last three elements) and add the new one to the beginning
		//	echo "There are 15 searches.  Removing last recent search.";
			array_pop($newRecent);
			array_pop($newRecent);
			array_pop($newRecent);
			
			array_unshift($newRecent, $mostRecent[0], $mostRecent[1], $mostRecent[2]);
		}
			
		//Convert the new array into a string, and change the recentMap string in the database to the new one
		
		$newRecentString = implode(",", $newRecent);
		//echo "<br> New string: $newRecentString <br>";
		

		$sql = "UPDATE Login 
				  SET recentMap = '$newRecentString'
				  WHERE Username = '$username'";

		$query = mysqli_query($con, $sql);
		if (!$query) {
			echo "Query failed<br><br>";
		}
	}
	

	
	
	
	
	
	
	
	
	
	
	
    $pointsArray = array();
    $pointsArray = mapTrafficPoints($zipcode, $timeSelected, $weatherSelected);
    //$pointsToEncode = array();
    //$pointsEncodeIndex = 0;
    //$pointsIndex = 0;
    //while($$pointsIndex<count($points)) {
    //    $$pointsIndex1 = $$pointsIndex + 1;
    //    $points[$$pointsEncodeIndex] = array('x'=>$arr[$x], 'y'=>$arr[$x1]);
    //    $$pointsEncodeIndex++;
    //    $$pointsIndex += 2; 
    //}
    //$polylineEncoder = new PolylineEncoder();

    //foreach ($pointsToEncode as $point) {
    //    $polylineEncoder->addPoint($point['x'], $point['y']);
    //}
    //$encodedString = $polylineEncoder->encodedString();
    
    //intensity 1 - 00FF00
    //intensity 2 - CCFF00
    //intensity 3 - FFFF00
    //intensity 4 - FF9900
    //intensity 5 - FF0000
    $color1 = 'markers=color:0x00FF00';
    $color2 = 'markers=color:0xCCFF00';
    $color3 = 'markers=color:0xFFFF00';
    $color4 = 'markers=color:0xFF9900';
    $color5 = 'markers=color:0xFF0000';
    $flag1 = 0;
    $flag2 = 0;
    $flag3 = 0;
    $flag4 = 0;
    $flag5 = 0;
    
    foreach ($pointsArray as $point) {
        if($point['color'] == 1) {
            $color1 .= '|' . $point['lngLat'];
            $flag1 = 1;
        }
        else if($point['color'] == 2) {
            $color2 .= '|' . $point['lngLat'];
            $flag2 = 1;
        }
        else if($point['color'] == 3) {
            $color3 .= '|' . $point['lngLat'];
            $flag3 = 1;
        }
        else if($point['color'] == 4) {
            $color4 .= '|' . $point['lngLat'];
            $flag4 = 1;
        }
        else if($point['color'] == 5) {
            $color5 .= '|' . $point['lngLat'];
            $flag5 = 1;
        }
    }
    
    //for google
    //key: AIzaSyAdM76kzhZ0uwCyHxZLogbt5Sc9PrF1RpM
    //link: http://maps.googleapis.com/maps/api/staticmap?center=New+York,NY&zoom=13&size=600x300&key=API_console_key
    //$googleImgSrc = "http://maps.googleapis.com/maps/api/staticmap?center=" . $zipcode . "&zoom=10&size=640x640&scale=2&key=AIzaSyAdM76kzhZ0uwCyHxZLogbt5Sc9PrF1RpM";
    $googleImgSrc = "http://maps.googleapis.com/maps/api/staticmap?size=640x640&scale=4&key=AIzaSyAdM76kzhZ0uwCyHxZLogbt5Sc9PrF1RpM";
    $lastAnd = 0;
    if($flag1 == 1) {
        $googleImgSrc .= "&" . $color1 . "&";
        $lastAnd = 1;
    }
    if($flag2 == 1) {
        $googleImgSrc .= "&" . $color2 . "&";
        $lastAnd = 1;
    }
    if($flag3 == 1) {
        $googleImgSrc .= "&" . $color3 . "&";
        $lastAnd = 1;
    }
    if($flag4 == 1) {
        $googleImgSrc .= "&" . $color4 . "&";
        $lastAnd = 1;
    }
    if($flag5 == 1) {
        $googleImgSrc .= "&" . $color5 . "&";
        $lastAnd = 1;
    }
    if($lastAnd == 0) {
        $googleImgSrc .= "&center=" . $zipcode;
        echo "<label>No history found for " . $zipcode . "</label><br>";
    }
    if($lastAnd == 1) {
        $googleImgSrc .= "sensor=false";
    }
    else {
        $googleImgSrc .= "&sensor=false";
    }
    //can either echo or just construct it in html
    //$htmlImg = "<img id='mapImg' src= '" . $googleImgSrc . "' alt='Map Image of " . $zipcode . "'><label id='zoomLvl' value='10' style='display:none;'></label>";
    //echo $htmlImg;
    //for mapquest
    //key: Fmjtd%7Cluub2168nu%2Cax%3Do5-96zg9u
    //http://www.mapquestapi.com/staticmap/v4/getmap?key=YOUR_KEY_HERE&center=40.044600,-76.413100&zoom=10&size=400,200&type=map&imagetype=jpeg&pois=1,40.098579,-76.398703,-20,-20|orange-100,40.069116,-76.401178|green,40.098088,-76.346092|yellow-s,40.069607,-76.352282
    //http://www.mapquestapi.com/staticmap/v4/getmap?key=Fmjtd%7Cluub2168nu%2Cax%3Do5-96zg9u&location= zipcode &size=640,640&zoom=&scale=
}
?>
<img id='mapImg' src= '<?php echo $googleImgSrc ?>' alt='Map Image of <?php echo $zipcode ?>'>
<br>
<label id='zoomLvl' value='10' style='display:none;'></label>
<!--
<br>
<label><?php print_r($pointsArray); ?> </label>
<br>
<label><?php echo $color1; ?> </label>
<br>
<label><?php echo $color2; ?> </label>
<br>
<label><?php echo $color3; ?> </label>
<br>
<label><?php echo $color4; ?> </label>
<br>
<label><?php echo $color5; ?> </label>
-->