<?php
include("connection.php");
server_connect();

$name = $_GET["rssname"];
$url = $_GET["rssurl"];

$query = "delete from rssWebSite where siteurl = '".$url."'";
$result = pdo_query($query);

	if (!$result) {
		print("Failed to add new content: ".mysql_error());	
	} else {
		print("OK: \n NAME(".$name.") is removed");
	}
	
server_disconnect();
?>
