<?php
$hostName = 'fdb4.biz.nf';
$userName = '1270538_traffic';
$pw = 'traffic2013';
$dbName = '1270538_traffic';
//prefer to use odbc, but do not know if web service has dsn set up
//use mysql connections most likely easiest
$mySqli = new mysqli($hostname,$userName,$pw,$dbName);
?>