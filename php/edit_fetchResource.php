<!-- this file is called by edit.js -->
<?php
include("php_library.php");
$recipe = $_GET["recipe"];

$query = "select resource, resourcelink from recipe where name='".$recipe."'";
$result = exec_my_query($query);
$row = mysql_fetch_row($result);

//$row[0]: resource
//$row[1]: resource link
print($row[0]." | ".$row[1]);

mysql_free_result($result);
disconnectMysql();
?>