<?php
include("../skip/mysql_login.php");

try {
    $pdo = new PDO("mysql:host=" . $db_host . "; dbname=" . $db_name, $db_user, $db_pass, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ));
    //		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Connection Failed: " . $e->getMessage());
}

$filename = $_GET["filename"];

$prequery = $pdo->prepare("select * from " . $filename);

if ($prequery->execute() == false) {
    print("Failed!\nNot able to fetch " . $filename . " data...");
} else {
    
    Header("Content-Type: application/json");
    $data = array();
    
    while ($result = $prequery->fetch(PDO::FETCH_ASSOC)) {
        array_push($data, $result);
    }
    print(json_encode($data));
}
$pdo = null;
?>

