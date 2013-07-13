<?php
include("php_library.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
					  
<html>
 <head>
 	<title>EDIT PAGE</title>
 	<link href="../css/indexfinder_design.css" type="text/css" rel="stylesheet" media="screen"/>
	<script src="../js/edit_library.js" type="text/javascript"></script>
	<script src="../js/source/jquery-1.6.1.min.js" type="text/javascript"></script>
<!--	<script src="source/jquery.ui.core.js" type="text/javascript"></script>
 --></head>

<!-- <body onLoad="checkPass();"> -->
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
  <h2>Edit Data Page (*: MUST fill the area)</h2>
  
  <!--RECIPE EDIT-->
  <div id="recipe">
  <h3> RECIPE DATA SECTION ------------------------------ </h3>
  
  
  <script type="text/javascript">
  var a = [1, 2, 3, 4,4, 5, 5];
  $(function() {
  alert("in jquery");
  });
  //a = a.without(5);
  alert("here");
  </script>
  <form action="edit_process.php" id="createRecipeForm">
    <fieldset>
    	<legend>CREATE NEW RECIPE</legend>
    	<label>Recipe Name*: <input type="text" name="new_recipename" id="recipeNewMUSTname" size="50" /></label><br /><br />
    	<label>Resource Name: <input type="text" name="new_resource" size="48" /></label><br /><br />
		<label>Resource Link: <input type="text" name="new_link" size="50" /></label><br /><br />
    	<input type="hidden" name="purpose" value="create_recipe" />
    	<span>Add tag?</span><br />
    	
    	<input type="submit" value="APPLY"/>
    </fieldset>
  </form>
  <br />

  <form action="edit_process.php" id="changeRecipeForm">  
  <fieldset>
    	<legend>CHANGE RECIPE</legend>
		<span>I want to change this recipe: </span>
		<select name="changeRecipeSelection" id="recipeSelect" >
		<?php
			$query3 = "select name from recipe order by replace(name, '\"', '') asc";
			$result3 = exec_my_query($query3);
			while($row = mysql_fetch_row($result3)) {
				print("<option>".ucwords(strtolower($row[0]))."</option>");
			}
			mysql_free_result($result3);
		?>
		</select>
    	<input type="button" value="SELECT" id="selectButtonATchange"/><br />
		<p id="changes">
    	<label>Recipe Name*: <input type="text" name="change_recipename" id="changeName" size="50" visibility="hidden" /></label><br /><br />
    	<label>Resource Name: <input type="text" name="change_resource" id="changeResource" size="48" /></label><br /><br />
    	<label>Resource Link: <input type="text" name="change_link" id="changeResourceLink" size="50" /></label><br /><br />
    	<input type="hidden" name="purpose" value="change_recipe" />
    	<input type="submit" value="APPLY" id="applyButtonATchange"/>
    	</p>
    </fieldset>
  </form>
  <br />
  
  <form action="edit_process.php" id="deleteRecipeForm">  
    <fieldset>
    	<legend>DELETE RECIPE</legend>
		<select name="deleteRecipeSelection" id="recipeSelect" >
		<?php
			$query0 = "select name from recipe order by replace(name, '\"', '') asc";
			$result0 = exec_my_query($query0);
			while($row = mysql_fetch_row($result0)) {
				print("<option>".ucwords(strtolower($row[0]))."</option>");
			}
			mysql_free_result($result0);
		?>
		</select><br /><br />
    	<input type="hidden" name="purpose" value="delete_recipe" />
    	<input type="submit" value="SELECT" />
    </fieldset>
  </form>
  <br />
    
  </div>  
      
  <!--TAG EDIT-->
  <div id="tag">
  <h3> TAG DATA SECTION --------------------------------- </h3>  
  <form action="edit_process.php" id="createTagForm">
    <fieldset>
    	<legend>CREATE NEW TAG</legend>
    	<label>Tag Name*: <input type="text" name="new_tag" id="tagNewMUSTname" size="50" /></label><br /><br />
    	<input type="hidden" name="purpose" value="create_tag" />
    	<input type="submit" value="APPLY"/>
    </fieldset>
  </form>
  <br />
  
  <form action="edit_process.php" id="changeTagForm">  
  <fieldset>
    	<legend>CHANGE TAG NAME</legend>
		<select name="changeTagSelection" id="tagSelectChange" >
		<?php
			$query1 = "select name from tag order by name asc";
			$result1 = exec_my_query($query1);
			while($row = mysql_fetch_row($result1)) {
				print("<option>".ucwords(strtolower($row[0]))."</option>");
			}
			mysql_free_result($result1);
		?>
		</select>
		<span>TO</span>
    	<input type="text" name="change_tag" id="tagChangeMUSTname" size="20" />		
    	<input type="hidden" name="purpose" value="change_tag" /><br /><br />
    	<input type="submit" value="APPLY"/>
  </fieldset>
  </form>
  <br />  

  <form action="edit_process.php" id="deleteTagForm">  
  <fieldset>
    	<legend>DELETE TAG</legend>
		<select name="deleteTagSelection" id="tagSelectDelete" >
		<?php
			$query2 = "select name from tag order by name asc";
			$result2 = exec_my_query($query2);
			while($row = mysql_fetch_row($result2)) {
				print("<option>".ucwords(strtolower($row[0]))."</option>");
			}
			mysql_free_result($result2);
		?>
		</select><br /><br />
    	<input type="hidden" name="purpose" value="delete_tag" />
    	<input type="submit" value="SELECT" />
  </fieldset>
  </form>
  <br />   
  </div>  
  
 </div>
 
 <footer>
  <hr>
  <section>
   <div>created by mox2e*</div>
  </section>
 </footer> 
 </body>
 <?php
   	disconnectMysql();
 ?>
</html>