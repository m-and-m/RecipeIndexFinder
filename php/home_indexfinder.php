<?php
include("php_library.php");
$query = "select sitename, siteurl from rssWebSite order by sitename asc";
$result = exec_my_query("SET NAMES 'utf8';");
$result = exec_my_query($query);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
				  
<html>
 <head>
 	<title>INDEX FINDER</title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" > 	
 	<link href="../css/indexfinder_design.css" type="text/css" rel="stylesheet" media="screen"/>
 	<link href="../css/rss_design.css" type="text/css" rel="stylesheet" media="screen"/>
	<script src="../js/source/jquery-1.6.1.min.js" type="text/javascript"></script>	
	<script src="../js/source/jquery-v1.6.1.js" type="text/javascript"></script>	
	<script src="../js/home_rss.js" type="text/javascript"></script> 	
 </head>

 <body>
 
 <header>
  <h1>Recipe Index Finder*</h1><hr>
  
  <nav>
   <ul>
    <li class="page_item_home current_page_item"><a href="home_indexfinder.php">home</a></li>
    <li class="page_item_keyword"><a href="keyword_search.php">keyword</a></li>
    <li class="page_item_list"><a href="list_search.php">list</a></li>
    <li class="page_item_tag"><a href="tag_search.php">tag</a></li> 
    <li class="page_item_edit"><a href="edit.php">edit</a></li> 
    <li class="page_item_export"><a href="export.php">export</a></li>     
   </ul>
  </nav>
 </header>
 
 <div class="content">
  <hr>
  <h2>Today's RSS Feed*:) --- constructing</h2>
  <span>Turn on JavaScript to use this program.</span>
  <h3> --------------------------------------------------------------- </h3>
  <!-- RSS feeds come here -->
  <div id="rss_content"><table></table></div>
  <!-- subscribed urls come here -->
  <div id="url_section">
   <span>+Add Contents</span>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <span>+Remove Contents</span>
   <span>---------------------------------------------<span>
   <table id="url_table">
   <?php
   		/*
   		$site[0]:name
   		$site[1]:url
   		*/
   		while($site = mysql_fetch_row($result)) {
   			//print(iconv("UTF-8", "ASCII//TRASLIT", $site[0]));
   			/*$ustr = $site[0];
   			print("<pre>".ord($ustr[0])."</pre>");
   			print("<pre>".ord($ustr[1])."</pre>");
   			print("<pre>".ord($ustr[2])."</pre>");
   			print("<pre>".ord($ustr[3])."</pre>");*/
   			print("<tr><td><a href=".$site[1].">".$site[0]."</a></td></tr>");
   		}
		mysql_free_result($result);
		
   ?>
   </table>
   </div>
 </div>
<?php
   	disconnectMysql();
?>
 <footer>
  <hr>
  <section>
   <div>created by mox2e*</div>
  </section>
 </footer> 
 </body>
 
</html>