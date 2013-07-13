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
	$recipeName = $_REQUEST["new_recipename"];
	$resourceName = $_REQUEST["new_resource"];
	$resourceLink = $_REQUEST["new_link"];

	$query1 = "select max(recipeid) from recipe";
	$result1 = exec_my_query($query1);

	$maxIDnum = mysql_fetch_row($result1);
	$currIDnum = $maxIDnum[0]+1;
	mysql_free_result($result1);

	$query2= "insert into recipe value(".$currIDnum.", '".$recipeName."', '".$resourceName."', '".$resourceLink."')";
	$result2 = exec_my_query($query2);

	if ($result2 != 1) {
		print("Failed to create new recipe data: ".mysql_error()."<br />");	
	} else {
		print("Succeed to create new recipe: ");
		print("<br /> ID: ".$currIDnum.
		 	  "<br /> Name: ".$recipeName.
		 	  "<br /> Resource: ".$resourceName.
		 	  "<br /> Link: ".$resourceLink."<br />");
	}
} else if ($purpose == "change_recipe") { 
//	print("@edit_process Change Recipe<br />");
	
	$origRecipe = $_REQUEST["changeRecipeSelection"];
	$recipe = $_REQUEST["change_recipename"];
	$resource = $_REQUEST["change_resource"];
	$resourceLink = $_REQUEST["change_link"];
	
	$query0 = "select recipeid from recipe where name='".$origRecipe."'";
	$result0 = exec_my_query($query0);
	$id = mysql_fetch_row($result0);
	mysql_free_result($result0);
	
	$query1 = "update recipe set name='".$recipe.
						 "', resource='".$resource.
						 "', resourcelink='".$resourceLink."' where recipeid = ".$id[0];
	$result1 = exec_my_query($query1);
	
	if ($result1 != 1) {
		print("Failed to update recipe data: ".mysql_error()."<br />");	
	} else {
		print("Succeed to update recipe (".$origRecipe."): ");
		print("<br /> NEW Name: ".$recipe.
		 	  "<br /> NEW Resource: ".$resource.
		 	  "<br /> NEW Link: ".$resourceLink."<br />");
	}
	
} else if ($purpose == "delete_recipe") {
	$deleteName = $_REQUEST["deleteRecipeSelection"];

	$query1 = "select recipeid from recipe where name = '".$deleteName."'";
	$result1 = exec_my_query($query1);
	
	$deleteID = mysql_fetch_row($result1);
	mysql_free_result($result1);

	$query2 = "delete from recipe where recipeid = ".$deleteID[0];
	$result2 = exec_my_query($query2);

	if ($result2 != 1) {
		print("Failed to delete recipe data: ".mysql_error()."<br />");	
	} else {
		print("Succeed to delete recipe: ");
		print("<br /> ID: ".$deleteID[0].
			  "<br /> Name: ".$deleteName."<br />");
	}	
} else if($purpose == "create_tag") {
	$tagName = $_REQUEST["new_tag"];
	print("@create tag: ".$tagName."<br />");
	
	$query0 = "select * from tag order by tagid desc limit 1";
	$result0 = exec_my_query($query0);
	$lastID = mysql_fetch_row($result0);
	mysql_free_result($result0);	
	
	$lastDigit = substr($lastID[0], 1);
	$currDigit = $lastDigit+1;
	
	print("The last digit (".$currDigit."), its type (".gettype($currDigit).")<br />");
	
	$query1 = "insert into tag value('T".$currDigit."', '".$tagName."')";
	$result1 = exec_my_query($query1);

	if ($result1 != 1) {
		print("Failed to create tag data: ".mysql_error()."<br />");	
	} else {
		print("Succeed to create tag: ");
		print("<br /> ID: T".$currDigit.
			  "<br /> Name: ".$tagName."<br />");
	}		
} else if($purpose == "change_tag") {
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
	$deleteName = $_REQUEST["deleteTagSelection"];

	$query0 = "select tagid, name from tag where name = '".$deleteName."'";
	$result0 = exec_my_query($query0);	
	
	$deleteTag = mysql_fetch_row($result0);
	mysql_free_result($result0);

	$query1 = "delete from tag where name='".$deleteName."'";
	$result1 = exec_my_query($query1);

	if ($result1 != 1) {
		print("Failed to delete tag data: ".mysql_error()."<br />");	
	} else {
		print("Succeed to delete tag: ");
		print("<br /> ID: ".$deleteTag[0].
			  "<br /> Name: ".$deleteTag[1]."<br />");
	}	
	
}
  disconnectMysql();
?>
 <br /><a href="edit.php"><input type="button" value="BACK to EDIT" /></a> 
 </div>
 
 <footer>
  <hr>
  <section>
   <div>created by mox2e*</div>
  </section>
 </footer> 
 </body>
</html>