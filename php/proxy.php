<?php
$xmlLink = $_GET["xml"];

// open the cURL session
$session = curl_init($xmlLink);
// don't return HTTP header
curl_setopt($session, CURLOPT_HEADER, false);
// don't return the contents of the call
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
// make the call
$xml = curl_exec($session);
// set the content type
header("Content-Type: text/xml");
//array_push($xmlHolder, $xml);
print($xml);

curl_close($session);
?>
