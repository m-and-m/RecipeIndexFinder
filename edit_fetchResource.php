<?php
include("mox2e_php_library.php");
$recipe = $_GET["recipe"];

$query = "select resource, resourcelink from recipe where name='".$recipe."'";
$result = exec_my_query($query);
$row = mysql_fetch_row($result);

//$row[0]: resource
//$row[0]: resource link
print($row[0]." | ".$row[1]);

mysql_free_result($result);
disconnectMysql();
?>