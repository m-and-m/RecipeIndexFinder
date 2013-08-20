<?php
include("connection.php");
server_connect();

$name = $_GET["rssname"];
$siteid = $_GET["siteid"];

pdo_transactionstart();

$query = "delete from rssWebSite where siteid = '".$siteid."'";
$result = pdo_query($query);

	if ($result == false) {
		print("Failed to add new content: ".mysql_error());	
	} else {
		pdo_commit();
		print("OK: \n NAME(".$name.") is removed");
	}

server_disconnect();
?>
