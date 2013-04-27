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
    $zipcode = preg_replace($pattern,$replacement,$zipcode);
    //$con = mysqli_connect("fdb4.biz.nf","1270538_traffic","Software2013","1270538_traffic");
    $con = mysqli_connect("localhost","traffich_admin","Admin2013","traffich_main");

    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
        
    //query select * from table where condition
    //format $time and zipcode(possibly if we dont use actualy zipcode
    $query = "SELECT Date_Time, Traffic_Severity, Longitude, Latitude, Zipcode, Weather
                FROM Traffic_Display
                WHERE Date_Time=" . $time . " AND Zipcode= " . $zipcode . " AND Weather='" . $weather . "'";
    $queryTwo = "SELECT * FROM Traffic_Counter";
    if ($result = $con->query($queryTwo)) {
        while($row = $result->fetch_row()) {
            $callCounter = $row[1];
        }
    }
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
            $resultArray[$resultIndex] = array('lngLat'=>$lngLat,'color'=>$colorNumber);
            $resultIndex++;
        }
    }
    else {
        $resultArray[0] = 1;
   } 
    
    $result->close();
    mysqli_close($con);
    return $resultArray;
}

function mobileReport($zipcode, $severity, $street, $county, $state, $shortDes, $lat, $long) {
    /*  
     */
    
    //Create connection
    //mysqli_connect(host,username,password,dbname);
    $success = 0;
    $con = mysqli_connect("localhost","traffich_admin","Admin2013","traffich_main");

    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        $success = 1;
    }
    
    $query = mysqli_query($con,"INSERT INTO Traffic_Mobile (Zipcode,Latitude,Longitude,Severity,Short_descrip,Address,County,State) VALUES ($zipcode,$lat,$long,$severity,$shortDes,$street,$county,$state)");
    if ($query) {
        $success = 1;
    }
    mysqli_close($con);
    return $success;
}
?>