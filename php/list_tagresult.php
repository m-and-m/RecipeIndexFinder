<?php
include("php_library.php");
$id = $_GET["id"];
$name = $_GET["name"];

$query = "select recipeid, name from recipe ".
		 "where recipeid in (select recipeid from recipeTag where tagid='".$id.
		 "') order by name asc";
$result = exec_my_query($query);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
					  
<html>
 <head>
 	<title>TAG RESULT</title>
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
    <li class="page_item_tag current_page_item"><a href="tag_search.php">tag</a></li> 
    <li class="page_item_edit"><a href="edit.php">edit</a></li> 
    <li class="page_item_export"><a href="export.php">export</a></li>     
   </ul>
  </nav>
 </header>
 
 <div class="content">
  <hr>
  <?php
  $numRow = mysql_num_rows($result);
  print("<h2>Tag Result Page (".$numRow." items)</h2>");

  print("<h3>You will see [IndexID : Recipe Title] ------------------------------------------------ </h3>");
 
  $id = "recipeid";
  $name = "name";
  if(strpos($_SERVER['SCRIPT_NAME'], "list") != FALSE) {
	$filename = "list";
  }

  display_list($numRow, $result, $id, $name, $filename);
    
  mysql_free_result($result);
  disconnectMysql();
 ?>
 
 </div>
 
 <footer>
  <hr>
  <section>
   <div>created by mox2e*</div>
  </section>
 </footer> 
 </body>
 
</html>