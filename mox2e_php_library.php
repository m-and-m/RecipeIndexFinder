<?php
include("mysql_login.php");
/******************************* (DIS)CONNECT TO SERVER ************************************/
  $conn = mysql_connect($db_host, $db_user, $db_pass);
  if(!$conn) {
  	die("Failed to connect database: ".mysql_error()."<br />");
  } 
  
  /*
  Choose database: index_finder
  */
  $db = mysql_select_db($db_name, $conn);
  if(!$db) {
    die("Failed to select database, 'index_finder': ".mysql_error()."<br />");
  } 

  function disconnectMysql() {
    GLOBAL $conn;
	mysql_close($conn);
  }
/********************************** QUERY *****************************************/
  /*
  Execute the giving query
  
  "mysql_query()" will get the data in this form:
  array(4) {
 	 [0]=> valueA
 	 ["recipeid"]=> valueA
 	 [1]=> valueB
 	 ["name"]=> valueB
  }
  */
  function exec_my_query($query){
  	$result = mysql_query($query);
  	if(!$result) {
    	die("Failed to fetch data: ".mysql_error()."<br />");
  	}
  	return $result;
  }
  
/******************************** DISPLAY IN 2 COLUMNS *********************************/ 

  function display_list($numRow, $rawData, $id, $name, $file) {
    
    if($numRow == 0) {
    	print("<p>Not found any...Please try again :'(</p>");
	    print("<a href='keyword_search.php'><input type='button' value='BACK to KEYWORD' /></a>"); 
    	exit();
    }
    
    /*
  	Calculate the 'turnback' row number
  	*/
  	if(fmod($numRow, 2) == 1) {
  		$half_num_row = ceil($numRow / 2);
  	} else { // the number of row is even
  		$half_num_row = $numRow / 2;
  	} 
//  print($half_num_row."<br />");
  
  	/*
  	Divide a whole data into left/right side of array
  	Display each array into left/right side of page
  	*/
  	$leftData = array();
  	$rightData = array();
  	$count = 1;

  	while ($row = mysql_fetch_array($rawData)) { 
  		if($count <= $half_num_row) {
  			array_push($leftData, $row);
  		} else if ($count > $half_num_row) {
  			array_push($rightData, $row);
  		} 	
  		$count++;
  	}
//  print(count($leftData)."<br />");

	/**
	Check the file name if it contains "list" or "tag" 
	because the way to display the list is different between them
	**/
	if($file == "list") {
		list_list($id, $name, $leftData, $rightData);
	} else if ($file == "tag"){
		tag_list($id, $name, $leftData, $rightData);
	}
	
} // display_list

 function tag_list($id, $name, $leftData, $rightData) {
   	print("<div id='left_column'><ul>");
   	dumpUnorderTagList($leftData);
  	print("</ul></div>");	 	
  
  	print("<div id='right_column'><ul>");
   	dumpUnorderTagList($rightData);
   	print("</ul></div>"); 

 } // tag_list
 
  function dumpUnorderTagList($data) {
   	GLOBAL $id;
 	GLOBAL $name;
 	
 	for($i = 0; $i < count($data); $i++){
  		$tagId = $data[$i][$id];
  		$tagName = ucwords(strtolower($data[$i][$name]));
  		$result_1stChar = checkFirstChar($tagName);

  		if ($result_1stChar == 2) {
  			print("<span>".strtoupper(substr($tagName, 1, 1))."</span><br />");
  		} else if($result_1stChar == 1) {
  			print("<span>".substr($tagName, 0, 1)."</span><br />");
  		}

		print("<li><a href='list_tagresult.php?id=".$tagId."&name=".$tagName."'>".
			  $tagName."</a></li>");
  	}

  } // dumpUnorderTagList
  
  function list_list($id, $name, $leftData, $rightData) {
  	$currDivisor = "";
  	print("<div id='left_column'><ul>");
  	dumpUnorderList($leftData);
  	print("</ul></div>");	 	
  
  	print("<div id='right_column'><ul>");
  	dumpUnorderList($rightData);
  	print("</ul></div>");  
 } // list_list
 
 function dumpUnorderList($data) {
 	GLOBAL $id;
 	GLOBAL $name;
 	
   	for($i = 0; $i < count($data); $i++){
  		$recipeName = ucwords($data[$i][$name]);
  		$result_1stChar = checkFirstChar($recipeName);

  		if ($result_1stChar == 2) {
  			print("<span>".strtoupper(substr($recipeName, 1, 1))."</span><br />");
  		} else if($result_1stChar == 1) {
  			print("<span>".substr($recipeName, 0, 1)."</span><br />");
  		}
		  print("<li>".$data[$i][$id]." : ".$recipeName."</li>");  	
	}
 } // dumpUnorderList
 
 /**
 Check the string if it has same first char as previous string.
 Return: 1 - if the string has new first character
 		 0 - if the string has same first character as before
 		 2 - Special case...the string starts with '"'
 **/
 function checkFirstChar($str) {
 	GLOBAL $currDivisor;
 	$firstChar = substr($str, 0, 1);
 	
 	if($firstChar == "\"") {
 		return 2;
  	} 
 	
 	$newDivisor = $firstChar; 	
 	
 	if($currDivisor != $newDivisor) {
 		$currDivisor = $newDivisor;
 		
 		return 1;
 	} 
 	return 0;
 } // checkFirstChar
?>
