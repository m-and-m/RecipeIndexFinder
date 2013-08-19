<?php
include("php_library.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
					  
<html>
 <head>
 	<title>INDEX FINDER</title>
 	<link href="../css/indexfinder_design.css" type="text/css" rel="stylesheet" media="screen"/>
 </head>

 <body>
 
 <header>
  <h1>Recipe Index Finder*</h1><hr>
  
  <nav>
   <ul>
    <li class="page_item_home"><a href="home_indexfinder.php">home</a></li>
    <li class="page_item_keyword"><a href="keyword_search.php">keyword</a></li>
    <li class="page_item_list"><a href="list_search.php">list</a></li>
    <li class="page_item_tag"><a href="tag_search.php">tag</a></li> 
    <li class="page_item_edit current_page_item "><a href="edit.php">edit</a></li> 
    <li class="page_item_export"><a href="export.php">export</a></li>     
   </ul>
  </nav>
 </header>
 
 <div class="content">
  <hr>
  <h2>Edit Process Page</h2>
<?php
$purpose = $_REQUEST["purpose"];

if($purpose == "create_recipe") {
/*
	Create new recipe including id, name, resource name, resource link, and tags 
*/
	$recipeName = $_REQUEST["new_recipename"];
	$resourceName = $_REQUEST["new_resource"];
	$resourceLink = $_REQUEST["new_link"];
	
	// get URL query
	$urlquery = $_SERVER["QUERY_STRING"];
	
	// locate first tag position
	$firsttag = strpos($urlquery, "tags=");

	// extract tags part from entire URL query
	$alltags = substr($urlquery, $firsttag);

	// split tag contains "tags=" part
	$splittags = explode("&", $alltags);

	/* trim the "tags=" and store each tag into array
   	   trimedtags[][0] = tag name
	   trimedtags[][1] = tag id
	 */
	$trimedtags = array();

	foreach($splittags as $key => $value) {	
		//print("key: ".$key." value: ".$value."<br/>");
		$trimedtags[$key][0] = urldecode(trim($value, "tags="));
	}
	
//	print("<br/>AFTER store tag name<br/>");
//	var_dump($trimedtags);

// 1) complete creating recipe data in RECIPE table	
	$query1 = "select max(recipeid) from recipe";
	$result1 = exec_my_query($query1);

	$maxIDnum = mysql_fetch_row($result1);
	$currIDnum = $maxIDnum[0]+1;
	mysql_free_result($result1);

//	print("<pre>'$recipeName' from edit_process.php</pre><br />\n");
//	print("<pre>'$resourceName' from edit_process.php</pre><br />\n");

	$result2 = exec_my_query("SET NAMES 'utf8';");	
	$query2= "insert into recipe value(".$currIDnum.", '".$recipeName."', '".$resourceName."', '".$resourceLink."')";
	$result2 = exec_my_query($query2);
    
	if ($result2 != 1) {
		print("Failed to create new recipe data: ".mysql_error()."<br />");	
		return;
	} 
	
// 2) get all tag's ids and store in the same 2d array as tag name stores

	foreach($trimedtags as $key => $value) {	
	
		// 'preg_quote' handles those special characters: . \ + * ? [ ^ ] $ ( ) { } = ! < > | : -
		// Doesn't include ' 
		$vlidatedvalue = str_replace("'", "\'", preg_quote($value[0]));
//		print("<br/>key: ".$key." value: ".$value[0]." quoted: ".$vlidatedvalue."<br/>");	
		
		$query3 = "select tagid from tag where name = '".$vlidatedvalue."'";
		$result3 = exec_my_query($query3);
		$tagID = mysql_fetch_row($result3);
		$trimedtags[$key][1] = $tagID[0];
		mysql_free_result($result3);
	}
	
//	var_dump($trimedtags);


// 3) complete adding the set of recipeid + tagid into RECIPETAG table
	foreach($trimedtags as $key => $value) {	
		//print("<br/>key: ".$key." value: ".$value[0]."<br/>");
		$query4 = "insert into recipeTag value(".$currIDnum.", '".$value[1]."')";
		$result4 = exec_my_query($query4);

		if ($result4 != 1) {
			print("Failed to add recipeID and tagID into recipeTag: ".mysql_error()."<br />");	
			return;
		} 
	}

	print("Succeed to create new recipe: ");
	print("<br /> ID: ".$currIDnum.
	 	  "<br /> Name: ".$recipeName.
	 	  "<br /> Resource: ".$resourceName.
	 	  "<br /> Link: ".$resourceLink.
	 	  "<br /> Tags: ");
	 	  
	foreach($trimedtags as $key => $value) {	
		print($value[0].", ");
	}

} else if ($purpose == "change_recipe") { 
/*
	Change an existing recipe including id, name, resource name, resource link, and tags 
*/

	$origRecipe = $_REQUEST["changeRecipeSelection"];
	$recipe = $_REQUEST["change_recipename"];
	$resource = $_REQUEST["change_resource"];
	$resourceLink = $_REQUEST["change_link"];
	
	$newtags = $_REQUEST["changeTagSelection"];
	
	try{
		$transquery = "start transaction";
		exec_my_query($transquery);	

		$query0 = "select recipeid from recipe where name='".$origRecipe."'";
		$result0 = exec_my_query($query0);
		$id = mysql_fetch_row($result0);
		mysql_free_result($result0);
	
		$query1 = "update recipe set name='".$recipe.
		  		  "', resource='".$resource.
				  "', resourcelink='".$resourceLink."' where recipeid = ".$id[0];
		$result1 = exec_my_query($query1);

		$query2 = "delete from recipeTag where recipeid =".$id[0];
		$result2 = exec_my_query($query2);

		for($i = 0; $i < count($newtags); $i++) {
			$query3 = "insert into recipeTag values(".$id[0].", '".$newtags[$i]."')";
			$result3 = exec_my_query($query3);
		}
		
		$commitquery = "commit";
		exec_my_query($commitquery);	
		
		print("Succeed to update of recipe [ID: ".$id[0].", OLD Name: ".$origRecipe."] ");
		print("<br /> NEW Name: ".$recipe.
	 		  "<br /> NEW Resource: ".$resource.
		 	  "<br /> NEW Link: ".$resourceLink);
		print("<br /> NEW Tags: ");
		
		foreach($newtags as $tagid) {	
			$query3 = "select name from tag where tagid ='".$tagid."'";
			$result3 = exec_my_query($query3);
			$row = mysql_fetch_row($result3);
			mysql_free_result($result3);
			
			print($row[0].", ");
		}

	} catch(Exception $e) {
		$rollbackquery = "rollback";
		exec_my_query($rollbackquery);	
		print("Error: ".$e);
	}
	
} else if ($purpose == "delete_recipe") {
/*
	Delete recipe from RECIPE table, and also from RECIPETAG table
	Use atomic deletion	
*/
	$deleteName = $_REQUEST["deleteRecipeSelection"];

	$query1 = "select recipeid from recipe where name = '".$deleteName."'";
	$result1 = exec_my_query($query1);
	
	$deleteID = mysql_fetch_row($result1);
	mysql_free_result($result1);

	try{
		$transquery = "start transaction";
		exec_my_query($transquery);	

		$query2 = "delete from recipeTag where recipeid = ".$deleteID[0];
		exec_my_query($query2);

		$query3 = "delete from recipe where recipeid = ".$deleteID[0];
		exec_my_query($query3);

		$commitquery = "commit";
		exec_my_query($commitquery);	
		
		print("Succeed to delete recipe: ");
		print("<br /> ID: ".$deleteID[0].
			  "<br /> Name: ".$deleteName."<br />");

	} catch(Exception $e) {
		$rollbackquery = "rollback";
		exec_my_query($rollbackquery);	
		print("Error: ".$e);
	}
} else if($purpose == "create_tag") {
/*
	Create new tag including id and name 
*/
	$tagName = $_REQUEST["new_tag"];
//	print("@create tag: ".$tagName."<br />");
	
	$query0 = "select * from tag order by tagid desc limit 1";
	$result0 = exec_my_query($query0);
	$lastID = mysql_fetch_row($result0);
	mysql_free_result($result0);	
	
	$lastDigit = substr($lastID[0], 1);
	$currDigit = $lastDigit+1;
		
	$query1 = "insert into tag value('T".$currDigit."', '".$tagName."')";
	$result1 = exec_my_query($query1);

	if ($result1 != 1) {
		print("Failed to create tag data: ".mysql_error()."<br />");	
	} else {
		print("Succeed to create tag: ");
		print("<br /> ID: T".$currDigit.
			  "<br /> Name: ".str_replace("\\", "", $tagName)."<br />");
	}		
} else if($purpose == "change_tag") {
/*
	Change an existing tag including id and name 
*/
	$originalTag = $_REQUEST["changeTagSelection"];
	$changeTag = $_REQUEST["change_tag"];
	
	$query = "update tag set name='".$changeTag."' where name='".$originalTag."'";
	$result = exec_my_query($query);
	if ($result != 1) {
		print("Failed to update tag data: ".mysql_error()."<br />");	
	} else {
		print("Succeed to update tag: ");
		print("FROM (".$originalTag.") TO (".$changeTag.")<br />");
	}	
} else if ($purpose == "delete_tag") {
/*
	Delete tag from TAG table, and also from RECIPETAG table
	Use atomic deletion
*/
	$deleteName = $_REQUEST["deleteTagSelection"];

	$query0 = "select tagid from tag where name = '".$deleteName."'";
	$result0 = exec_my_query($query0);	
	$deleteID = mysql_fetch_row($result0);
	mysql_free_result($result0);
	
	try{
		$transquery = "start transaction";
		exec_my_query($transquery);	

		$query1 = "delete from recipeTag where tagid = '".$deleteID[0]."'";
		exec_my_query($query1);	

		$query2 = "delete from tag where name='".$deleteName."'";
		exec_my_query($query2);

		$commitquery = "commit";
		exec_my_query($commitquery);	
		
		print("Succeed to delete tag: ");
		print("<br /> ID: ".$deleteID[0].
			  "<br /> Name: ".str_replace("\\", "", $deleteName)."<br />");

	} catch(Exception $e) {
		$rollbackquery = "rollback";
		exec_my_query($rollbackquery);	
		print("Error: ".$e);
	}	
}
  disconnectMysql();
?>
 <br /><br /><a href="edit.php"><input type="button" value="BACK to EDIT" /></a> 
 </div>
 
 <footer>
  <hr>
  <section>
   <div>created by mox2e*</div>
  </section>
 </footer> 
 </body>
</html>