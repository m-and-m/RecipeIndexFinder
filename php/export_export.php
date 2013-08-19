<?php
include("../skip/mysql_login.php");

try {
    $pdo = new PDO("mysql:host=" . $db_host . "; dbname=" . $db_name, $db_user, $db_pass);
    //		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Connection Failed: " . $e->getMessage());
}

$filename   = $_GET["filename"];
$expectname = "out_" . $filename . ".csv";

$pdo->beginTransaction();

$dir = $export_path;
$filelist = scandir($dir);

$found = array_search($expectname, $filelist);

if ($found == !false) { // the filename is already existed
    $filecount  = count(preg_grep("*" . $filename . "*", $filelist));
    $expectname = "out_" . $filename . $filecount . ".csv";
}

//	var_dump($filelist);
//	print($expectname."\n");
$result = $pdo->query("select * from " . $filename . " into outfile '" . $export_path . $expectname . "'" . " fields terminated by ',' optionally enclosed by '\"'" . " lines terminated by '\n'");

if ($result == false) {
    print("Export Failed!\nNot able to export " . $filename . " data...");
    $pdo->rollBack();
} else {
    print("Export Succeeded!\n" . "The file locates in " . $export_path . $expectname);
}

$pdo = null;
?>
