<?php
/*
    PHP file for mobile to post to
*/

include 'sqlQueries.php';
//include 'polyEncode.php';
if($_POST) {
    if(isset($_POST['zipcode'])) {
        $zipcode = $_POST['zipcode'];
    }
    else {
        //error coding for empty zipcode
    }
    if(isset($_POST['street'])) {
        $street = $_POST['street'];
    }
    else {
        //error coding for empty time
    }
    if(isset($_POST['severity'])) {
        $severity = $_POST['severity'];
    }
    else {
        //error coding for empty time
    }
    if(isset($_POST['street'])) {
        $street = $_POST['street'];
    }
    else {
        //error coding for empty time
    }
    if(isset($_POST['county'])) {
        $county = $_POST['county'];
    }
    else {
        //error coding for empty time
    }
    if(isset($_POST['state'])) {
        $state = $_POST['state'];
    }
    else {
        //error coding for empty time
    }
    if(isset($_POST['shortDes'])) {
        $shortDes = $_POST['shortDes'];
    }
    else {
        //error coding for empty time
    }
    if(isset($_POST['lat'])) {
        $lat = $_POST['lat'];
    }
    else {
        //error coding for empty time
    }
    if(isset($_POST['long'])) {
        $long = $_POST['long'];
    }
    else {
        //error coding for empty time
    }
    mobileReport($zipcode, $severity, $street, $county, $state, $shortDes, $lat, $long);
}
?>