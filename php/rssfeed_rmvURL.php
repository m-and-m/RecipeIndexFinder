<?php
include("php_library.php");

$name = $_GET["rssname"];
$url = $_GET["rssurl"];

$query = "delete from rssWebSite where siteurl = '".$url."'";
//print($query);

$result = exec_my_query($query);

	if (!$result) {
		print("Failed to add new content: ".mysql_error());	
	} else {
		print("OK: \n NAME(".$name.") is removed");
	}
	
disconnectMysql();

?>
