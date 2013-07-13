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
  <h2>RSS Process Page</h2>
  
  <?php
  $url = $_REQUEST["rssSelection"];
//  print("@rss_process.php<br />");
//  print("Picked this: ".$url."<br />");
  
  $session = curl_init($url);
  $xml = curl_exec($session);
  var_dump($xml."<br />"); 
  // Close the session
  curl_close($session); 
  ?>
<!--  <form action="rss_process.php" id="requestRssForm">
  <fieldset>
    	<legend>CHOOSE YOUR FAVORITE RSS</legend>
		<select name="rssSelection" id="" >
			<option value="http://feedblog.ameba.jp/rss/ameblo/giornofelice19/rss20.xml">
																	いとしのイギリス</option>
		</select>
    	<input type="hidden" name="purpose" value="select_rss" />
    	<input type="submit" value="SELECT"/>
  </fieldset>
  </form>
  -->
 </div>
 
 <footer>
  <hr>
  <section>
   <div>created by mox2e*</div>
  </section>
 </footer> 
 </body>
 
</html>