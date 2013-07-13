<?php
include("php_library.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
					  
<html>
 <head>
 	<title>KEY SEARCH</title>
 	<link href="../css/indexfinder_design.css" type="text/css" rel="stylesheet" media="screen"/>
	<script src="../js/keyword_library.js" type="text/javascript"></script>  	
 </head>

 <body>
 
 <header>
  <h1>Recipe Index Finder*</h1><hr>
  
  <nav>
   <ul>
    <li class="page_item_home"><a href="home_indexfinder.php">home</a></li>
    <li class="page_item_keyword current_page_item"><a href="keyword_search.php">keyword</a></li>
    <li class="page_item_list"><a href="list_search.php">list</a></li>
    <li class="page_item_tag"><a href="tag_search.php">tag</a></li> 
    <li class="page_item_edit"><a href="edit.php">edit</a></li> 
    <li class="page_item_export"><a href="export.php">export</a></li>         
   </ul>
  </nav>
 </header>
 
 <div class="content">
  <hr>
  <h2>Keyword Search Page</h2><br />
  
  <!--RECIPE KEYWORD-->
  <form action="list_keywordresult.php" id="keyRecipeSearch">
    <fieldset>
    	<legend>By Recipe Keyword...WHAT?</legend>
    	<input type="text" id="recipeKeyMUSTname" name="key" value="e.g.) ma-bo" size="50" onClick="this.value='';"/><br /><br />
    	<input type="hidden" name="search_type" value="recipe" />
    	<input type="submit" value="SEARCH"/>
    </fieldset>
  </form>
  
  <br />
  
  <!--TAG KEYWORD-->
  <form action="list_keywordresult.php" id="keyTagSearch">
    <fieldset>
    	<legend>By Tag Keyword...WHAT KIND?</legend>
    	<input type="text" id="tagKeyMUSTname" name="key" value="e.g.) tofu" size="50" onClick="this.value='';"/><br /><br />
    	<input type="hidden" name="search_type" value="tag" />    	
    	<input type="submit" value="SEARCH"/>
    </fieldset>
  </form>

 </div>
 
 <footer>
  <hr>
  <section>
   <div>created by mox2e*</div>
  </section>
 </footer> 
 </body>
 
</html>