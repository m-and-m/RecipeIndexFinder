<?php
include("connection.php");
server_connect();

$recipe = $_GET["recipe"];

$resourceInfo = "";

$query = "select recipeid, resource, resourcelink from recipe where name='".$recipe."'";
$result = pdo_query($query);

$row1 = $result->fetch();
$resourceInfo .=  $row1["resource"]."|".$row1["resourcelink"];

$query1 = "select tagid from recipeTag where recipeid = ".$row1["recipeid"];
$result1 = pdo_query($query1);

if($result1->rowCount() != 0) {
	foreach($result1 as $row2) {
		$resourceInfo .= "|".$row2[0];
	}
}

print($resourceInfo);

server_disconnect();
?>