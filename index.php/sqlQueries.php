<?php

function mapTrafficPoints($zipcode, $time, $weather) {
    //Create connection
    //mysqli_connect(host,username,password,dbname);
    $pattern = '/0(d+)/i';
    $replacement = '$1';
    $zipcode = preg_replace($pattern,$replacement,$zipcode);
    $con = mysqli_connect("fdb4.biz.nf","1270538_traffic","Software2013","1270538_traffic");

    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
        
    //query select * from table where condition
    //format $time and zipcode(possibly if we dont use actualy zipcode
    $query = "SELECT Date_Time, Traffic_Severity, Longitude, Latitude, Zipcode, Weather
                FROM Traffic_Incident
                WHERE Date_Time=" . $time . " AND Zipcode= " . $zipcode . " AND Weather='" . $weather . "'";
    $resultArray = array();
    $resultIndex = 0;
    if ($result = $con->query($query)) {
        //parse return
        while($row = $result->fetch_row()) {
            $lngLat = $row[3] . ',' . $row[2];
            $colorNumber = round($row[1]/10);
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
?>