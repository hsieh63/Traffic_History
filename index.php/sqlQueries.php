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
    //Select * from Weather as a and Traffic_Incident as b where a.Zipcode = b.Zipcode and a.Date_Time = b.Date_Time and a.Date_Time like '%$time'
    //$result = $mysqli->query($query)
    //parse return
    //while($row = $result->fetch_row()) {
    //put into array
    //}
    
    mysqli_close($con);
    //return rows array
}
?>