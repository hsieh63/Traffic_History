<?php

function mapTrafficPoints($zipcode, $time) {
    //Create connection
    //mysqli_connect(host,username,password,dbname);
    $con = mysqli_connect("fdb4.biz.nf","1270538_traffic","Software2013","1270538_traffic");

    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    //query select * from table where condition
    //$result = $mysqli->query($query)
    //parse return
    //while($row = $result->fetch_row()) {
    //put into array
    //}
    
    mysqli_close($con);
    //return rows array
}
?>