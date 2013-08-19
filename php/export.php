<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php

	try{
		$pdo = new PDO("mysql:host=localhost; dbname=index_finder", "indexfinder", "winter13");	
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		print("Connection Failed: ".$e->getMessage());
	}
	
/* OK	
	foreach($pdo->query('SELECT name from recipe') as $row) {
        print_r($row[0]."<br/>");
    }
*/
?>	
		  
<html>
 <head>
 	<title>EXPORT DATA</title>
 	<link href="../css/indexfinder_design.css" type="text/css" rel="stylesheet" media="screen"/>
 	<link href="../css/export_design.css" type="text/css" rel="stylesheet" media="screen"/>
 	<script src="../js/source/jquery-v1.6.1.js" type="text/javascript"></script>
 	<script src="../js/export.js" type="text/javascript"></script>
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
    <li class="page_item_edit"><a href="edit.php">edit</a></li> 
    <li class="page_item_export current_page_item"><a href="export.php">export</a></li>     
   </ul>
  </nav>
 </header>
 
 <div class="content">
  <hr>
  <h2>Export Data Page</h2>
  
  <span>Choose 1 file (.csv) to export / view:</span><br/><br/>

  <?php
 	foreach( $pdo->query("show tables") as $tablename) {
		print("<label><input type='radio' name='filechoice' value='".
			   $tablename[0]."'/>".ucfirst($tablename[0])."</label><br/>");
	}
	
	$pdo=null;
  ?>
  <br/>
  <input type="submit" value="EXPORT" id="export"/>
  &nbsp;
  <input type="submit" value="VIEW" id="view"/> 


<!--Make appear later?--> 
  <hr id="exportviewline">
  <div id="table_content"></div>
<!--Make appear later?-->  
  
 </div>
 
 <footer>
  <hr>
  <section>
   <div>created by mox2e*</div>
  </section>
 </footer> 
 </body>
 
</html>