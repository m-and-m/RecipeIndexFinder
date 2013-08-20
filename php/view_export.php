<?php
include("connection.php");
server_connect();
	
$filename = $_GET["filename"];
$query = "select * from ".$filename;

$prequery = pdo_prepare($query);
        
if($prequery->execute() == false) {
	print("Failed!\nNot able to fetch ".$filename." data...");  
} else {

  	Header("Content-Type: application/json");
   	$data = array();
   	
   	while($result = $prequery->fetch(PDO::FETCH_ASSOC)) {   		
   		array_push($data, $result);
   	}
	
	print(json_encode($data));
}   

server_disconnect();   
?>

