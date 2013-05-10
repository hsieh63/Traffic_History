<?php

function mapTrafficPoints($zipcode, $time, $weather) {
    /*  
        Function requires zipcode, time, weather input
        Will construct and execute sql query to find longitude and latitude and traffic severity to display points
        returns array of array of points
    */
    
    //Create connection
    //mysqli_connect(host,username,password,dbname);
    $pattern = '/0(d+)/i';
    $replacement = '$1';
    //$zipcode = preg_replace($pattern,$replacement,$zipcode);
    //$con = mysqli_connect("fdb4.biz.nf","1270538_traffic","Software2013","1270538_traffic");
    $con = mysqli_connect("localhost","traffich_admin","Admin2013","traffich_main");

    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
        
    //query select * from table where condition
    //format $time and zipcode(possibly if we dont use actualy zipcode
    if ($weather == 'all') {
        $query = "SELECT Date_Time, Severity, Longitude, Latitude, Zipcode, Weather
                FROM Traffic_Display
                WHERE Time_Value = " . $time . " AND Zipcode = '" . $zipcode . "'";
    }
    else {
        $query = "SELECT Date_Time, Severity, Longitude, Latitude, Zipcode, Weather
                FROM Traffic_Display
                WHERE Time_Value = " . $time . " AND Zipcode = '" . $zipcode . "' AND Weather = '" . $weather . "'";
    }
    $queryTwo = "SELECT * FROM Traffic_Counter";
    if ($result = $con->query($queryTwo)) {
        while($row = $result->fetch_row()) {
            $callCounter = $row[1];
        }
        $result->close();
    }
    
	//force call counter to certain value to give better traffic data
	$callCounter=7;
	
    $resultArray = array();
    $resultIndex = 0;
    if ($result = $con->query($query)) {
        //parse return
        while($row = $result->fetch_row()) {
            $lngLat = $row[3] . ',' . $row[2];
            $colorNumber = round($row[1]/$callCounter);
            if ($colorNumber > 5) {
                $colorNumber = 5;
            }
            if ($colorNumber <= 0) {
                $colorNumber = 1;
            }
            $resultArray[$resultIndex] = array('lngLat'=>$lngLat,'color'=>$colorNumber);
            $resultIndex++;
        }
        $result->close();
    }
    else {
        $resultArray[0] = 1;
    } 
    
    mysqli_close($con);
    return $resultArray;
}

function getPointsInBox($topLeftLat,$bottomRightLat,$topLeftLong,$bottomRightLong){
	/*
	function gets all points in Traffic_Display table that are within the box set by the inputs
	*/

	//connect to database
	$con = mysqli_connect("localhost","traffich_admin","Admin2013","traffich_main");
	if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

	//create query
	$query = 	"SELECT Latitude, Longitude 
				FROM `Traffic_Display` 
				WHERE `Latitude`<'" . $topLeftLat . "' AND `Latitude`>'" . $bottomRightLat . "' AND 
				`Longitude`>'" . $bottomRightLong . "' AND `Longitude`<'" . $topLeftLong . "'";
	//using same syntax as first method			
	$resultArray = array();
    $resultIndex = 0;			
	if ($result = $con->query($query)) {
        //parse return
        while($row = $result->fetch_row()) {
            $lngLat = $row[0] . ',' . $row[1];
            //$resultArray[$resultIndex] = $lngLat;
            //$resultIndex++;
            array_push($resultArray, $lngLat);
            //array_push($resultArray, "2");
        }
        $result->close();
    }
    else {
        array_push($resultArray, "0");
    } 

	mysqli_close($con);
    return $resultArray;
}


function mobileReport($zipcode, $severity, $street, $county, $state, $shortDes, $lat, $long) {
    /*  
     */
    
    //Create connection
    //mysqli_connect(host,username,password,dbname);
    $success = 2;
    $con = mysqli_connect("localhost","traffich_admin","Admin2013","traffich_main");

    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        $success = 1;
    }
    
    $query = mysqli_query($con,"INSERT INTO `Traffic_Mobile` (`Zipcode`,`Latitude`,`Longitude`,`Severity`,`Short_descrip`,`Address`,`County`,`State`) VALUES ('" . $zipcode . "'," . $lat . "," . $long . "," . $severity . ",'" . $shortDes . "','" . $street . "','" . $county . "','" . $state . "')");
    if ($query) {
        $success = 0;
    }
    mysqli_close($con);
    return $success;
}
?>