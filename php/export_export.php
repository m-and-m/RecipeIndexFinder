<?php
include("connection.php");
server_connect();
	
$filename   = $_GET["filename"];
$expectname = "out_" . $filename . ".csv";

$dir = $export_path;
$filelist = scandir($dir);

$found = array_search($expectname, $filelist);
if ($found == !false) { // the filename is already existed
    $filecount  = count(preg_grep("*" . $filename . "*", $filelist));
    $expectname = "out_" . $filename . $filecount . ".csv";
}
pdo_transactionstart();

$query = "select * from " . $filename . " into outfile '" .
		  $export_path . $expectname . "'" . 
		 " fields terminated by ',' optionally enclosed by '\"'" .
		 " lines terminated by '\n'";

$result = pdo_query($query);
if ($result == false) {
    print("Export Failed!\nNot able to export " . $filename . " data...");
    pdo_rollback();
} else {
    print("Export Succeeded!\n" . "The file locates in " . $export_path . $expectname);
}

server_disconnect();   
?>
