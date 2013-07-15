<?php
include("php_library.php");

$query = "select * from rssWebSite";
$result = exec_my_query($query);
$row = mysql_fetch_row($result); //row[0]:id, row[1]:sitename, row[2]:sitexml

// open the cURL session
$session = curl_init($row[2]);
// don't return HTTP header
curl_setopt($session, CURLOPT_HEADER, false); 	
// don't return the contents of the call
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
// make the call
$xml = curl_exec($session);
// set the content type
header("Content-Type: text/xml");
echo $xml; 

// Close the session
curl_close($session); 
disconnectMysql();
?>