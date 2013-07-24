<?php
include("php_library.php");

$name = $_GET["rssname"];
$url = $_GET["rssurl"];
$xml = $_GET["rssxml"];

//print("sitename: ".$name."\n siteurl: ".$url."\n sitexml".$xml);

$query0 = "select siteid from rssWebSite order by siteid desc";
$result0 = exec_my_query($query0);
$siteid = mysql_fetch_row($result0);
mysql_free_result($result0);

//ignore "RW"
$id_numpart = substr($siteid[0], 2);
$new_numpart = $id_numpart + 1;

//OK print("ID: ".$siteid[0]."\n #part: ".$id_numpart."\n new #part: ".$new_numpart);

$query1 = "insert into rssWebSite values('RW".$new_numpart."', '".$name."', '".$xml."', '".$url."')";
$result = exec_my_query("SET NAMES 'utf8';");
$result1 = exec_my_query($query1);

	if (!$result1) {
		print("Failed to add new content: ".mysql_error());	
	} else {
		print("OK: \n NAME(".$name."), FEEDXML(".$xml.")");
	}
	
disconnectMysql();

?>
