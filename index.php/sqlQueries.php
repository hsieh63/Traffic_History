<?php

function mapTrafficPoints() {
    //Create connection
    //mysqli_connect(host,username,password,dbname);
    $con = mysqli_connect("fdb4.biz.nf","1270538_traffic","Software2013","1270538_traffic");

    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    //$res = $con->query("");
    //parse return
    //return x;
    
    mysqli_close($con);
}
?>