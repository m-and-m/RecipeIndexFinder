<?php
include("php_library.php");
$recipe = $_GET["recipe"];

$resourceInfo = "";

$query = "select recipeid, resource, resourcelink from recipe where name='".$recipe."'";
$result = exec_my_query($query);

//$row1[0]: recipe id
//$row1[1]: resource
//$row1[2]: resource link
$row1 = mysql_fetch_row($result);
$resourceInfo .=  $row1[1]." | ".$row1[2];

$query1 = "select name from tag where tagid in (select tagid from recipeTag where recipeid = ".$row1[0].")";
$result1 = exec_my_query($query1);

while($row2 = mysql_fetch_row($result1)) {
	$resourceInfo .= " | ".$row2[0];
};

print($resourceInfo);

mysql_free_result($result);
mysql_free_result($result1);
disconnectMysql();
?>