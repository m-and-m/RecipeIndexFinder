<?php
include("connection.php");
server_connect();	
	
$queries = array("select name from tag order by name asc", 
				 "select name, tagid from tag order by name asc",
				 "select name from recipe order by replace(name, '\"', '') asc");
		
$count = 0;
$tagidcount = 0;

$tagArray = array();
$tagIDArray = array();
$recipeArray = array();

foreach($queries as $onequery) {

	$result = pdo_query($onequery);
	
 	foreach($result as $row) {
		switch($count) {
			case 0:
//				$tagcount++;
				array_push($tagArray, ucwords(strtolower($row[0])));
				break;
			case 1:
//				print($tagidcount."<br/>");
				$tagIDArray[$tagidcount] = array();
				/*
					row[0]: tag name
					row[1]: tag id
				*/
				array_push($tagIDArray[$tagidcount], ucwords(strtolower($row[0])));
				array_push($tagIDArray[$tagidcount], ucwords(strtolower($row[1])));
				$tagidcount++;
				break;
			case 2:
//				$recipecount++;
				array_push($recipeArray, ucwords(strtolower($row[0])));
				break;
			default: 
				break;
		}
	}
		$count++;
		$result = "";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
					  
<html>
 <head>
 	<title>EDIT PAGE</title>
 	 
 	<link href="../css/indexfinder_design.css" type="text/css" rel="stylesheet"/>
 	<link href="../css/jquery-ui-1.8.13.custom.css" type="text/css" rel="stylesheet"/>
 	<link href="../css/ui.dropdownchecklist.themeroller.css" type="text/css" rel="stylesheet"/> 
<!-- 	<link href="../css/ui.dropdownchecklist.standalone.css" type="text/css" rel="stylesheet"/> -->

	<script src="../js/source/jquery-v1.6.1.js" type="text/javascript"></script>
	<script src="../js/source/jquery-ui-1.8.13.custom.js" type="text/javascript"></script>	
	<script src="../js/source/ui.dropdownchecklist-1.4.js" type="text/javascript"></script>	
	<script src="../js/edit.js" type="text/javascript"></script>

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
  <h2>Edit Data Page (*: Required Fields )</h2>
  
  <!--RECIPE EDIT-->
  <div id="recipe">
  <h3> RECIPE DATA SECTION ------------------------------ </h3>

  <form action="edit_process.php" id="createRecipeForm"> 
    <fieldset>
    	<legend>CREATE NEW RECIPE</legend>
    	<label>Recipe Name*: <input type="text" name="new_recipename" id="recipeNewMUSTname" size="50" /></label><br /><br />
    	<label>Resource Name: <input type="text" name="new_resource" size="48" /></label><br /><br />
		<label>Resource Link: <input type="text" name="new_link" size="50" /></label><br /><br />
    	<input type="hidden" name="purpose" value="create_recipe" />
		<div>
		<select name="tags" id="addTags" multiple="multiple">
		<?php		
			foreach($tagArray as $onetag) {
				print("<option>".$onetag."</option>");
			}
		?>
		</select>
		</div><br />
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
			foreach($recipeArray as $onerecipe) {
				print("<option>".$onerecipe."</option>");
			}
		?>
		</select>
    	<input type="button" value="SELECT" id="selectButtonATchange"/><br />
		<p id="changes">
    	<label>Recipe Name*: <input type="text" name="change_recipename" id="changeName" size="50" /></label><br /><br />
    	<label>Resource Name: <input type="text" name="change_resource" id="changeResource" size="48" /></label><br /><br />
    	<label>Resource Link: <input type="text" name="change_link" id="changeResourceLink" size="50" /></label><br /><br />

		<span id="changeTagMemo">Select multiple tags with SUPER key</span><br />
		<select name="changeTagSelection[]" id="changeTagSelect" multiple="multiple" size="5">
		<?php		
			foreach($tagIDArray as $onetag) {
				print("<option value='".strtolower($onetag[1])."'>".$onetag[0]."</option>");
			}
		?>
		</select>

		<br />
    	<input type="hidden" name="purpose" value="change_recipe" />
    	<input type="submit" name="submit" value="APPLY" id="applyButtonATchange"/>
    	<input type="button" name="submit" value="CANCEL" id="cancelButtonATchange"/>
    	</p>
    </fieldset>
  </form>
  <br />
  
  <form action="edit_process.php" id="deleteRecipeForm">  
    <fieldset>
    	<legend>DELETE RECIPE</legend>
		<select name="deleteRecipeSelection" id="deleteRecipeSelect" >
		<?php
			foreach($recipeArray as $onerecipe) {
				print("<option>".$onerecipe."</option>");
			}
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
  <!-- 
    <form action="info.php" id="createTagForm">
  -->
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
			foreach($tagArray as $onetag) {
				print("<option>".$onetag."</option>");
			}
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
		<select name="deleteTagSelection" id="tagSelectDelete">
		<?php
			foreach($tagArray as $onetag) {
				print("<option>".$onetag."</option>");
			}
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
</html>

<?php
	 server_disconnect();
 ?>