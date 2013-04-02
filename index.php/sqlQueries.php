<?php

function mapTrafficPoints($zipcode, $time, $weather) {
    //Create connection
    //mysqli_connect(host,username,password,dbname);
    $con = mysqli_connect("fdb4.biz.nf","1270538_traffic","Software2013","1270538_traffic");

    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
        
    //query select * from table where condition
    //format $time and zipcode(possibly if we dont use actualy zipcode
    $query = 'SELECT t.Date_Time, t.Traffic_Severity, t.Latitude, t.Longitude, t.Zipcode, t.Weather
                FROM Traffic_Incident t
                WHERE t.Date_Time=3, t.Zipcode=7016, t.Weather=Sunny';
    $result = $mysqli->query($query);
    $resultArray = array();
    $resultIndex = 0;
    //parse return
    while($row = $result->fetch_row()) {
        $lngLat = $row[2] . ',' . $row[3];
        $colorNumber = $row[1]/10;
        $resultArray[resultIndex] = array('lngLat'=>$lngLat,'color'=>$colorNumber);
        $resultIndex++;
    }
    
    mysqli_close($con);
    return $resultArray;
}
?>