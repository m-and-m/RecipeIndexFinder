<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<?php
include("connection.php");
include("php_library.php");

server_connect();

?>
				  
<html>
 <head>
 	<title>TAG SEARCH</title>
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
  
  $query = "select tagid, name from tag group by tagid order by name asc";
  $result = pdo_query($query);

  $numRow = $result->rowCount();
  print("<h2>Tag Search Page (".$numRow." items)</h2>");
  
  $id = "tagid";
  $name = "name";
  if(strpos($_SERVER['SCRIPT_NAME'], "tag") != FALSE) {
	$filename = "tag";
  }
  
  display_list($numRow, $result, $id, $name, $filename);
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

 <?php
	 server_disconnect();
 ?>
