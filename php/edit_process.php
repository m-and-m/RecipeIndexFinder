<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<?php
include("connection.php");
server_connect();
iconv_set_encoding("internal_encoding", "UTF-8");
iconv_set_encoding("output_encoding", "UTF-8");
?>	
					  
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

if ($purpose == "create_recipe") {
    /*
    Create new recipe including id, name, resource name, resource link, and tags 
    */
    $recipeName   = $_REQUEST["new_recipename"];
    $resourceName = $_REQUEST["new_resource"];
    $resourceLink = $_REQUEST["new_link"];
    
    // 1) complete creating recipe data for RECIPE table	
    $query1  = "select max(recipeid) from recipe";
    $result1 = pdo_query($query1);
    
    $maxIDnum  = $result1->fetch();
    $currIDnum = $maxIDnum[0] + 1;
    
    $query2  = "insert into recipe value(" . $currIDnum . ", '" . $recipeName . "', '" . $resourceName . "', '" . $resourceLink . "')";
    $result2 = pdo_query($query2);
    
    if ($result2 == false) {
        print("Failed to create new recipe data: " . mysql_error() . "<br />");
        return;
    } 
    
    // 2) get all tag's ids and store in the same 2d array as tag name stores
    
    // get URL query
    $urlquery = $_SERVER["QUERY_STRING"];
    
    // locate first tag position
    $firsttag = strpos($urlquery, "tags=");
    
    if ($firsttag == false) { // not tag selected
//        print("NO TAG SELECTED!!!<br/>");
        print("Succeed to create new recipe: ");
        print("<br /> ID: " . $currIDnum . "<br /> Name: " . $recipeName . "<br /> Resource: " . $resourceName . "<br /> Link: " . $resourceLink);
        
        print("<br /><br /><a href='edit.php'><input type='button' value='BACK to EDIT' /></a> ");
        return;
        
    } // if
    
    // extract tags part from entire URL query
    $alltags = substr($urlquery, $firsttag);
    
    // split tag contains "tags=" part
    $splittags = explode("&", $alltags);
        
    $trimedtags = array();
    /* 
    trimedtags[][0] = tag name
    trimedtags[][1] = tag id
    */
    
    foreach ($splittags as $key => $value) {
        //print("key: ".$key.", value: ".$value.", trimed value: ".str_replace("tags=", "", $value)."<br/>");
        $trimedtags[$key][0] = urldecode(str_replace("tags=", "", $value));
    }
    
    foreach ($trimedtags as $key => $value) {
        
        // 'preg_quote' handles those special characters: . \ + * ? [ ^ ] $ ( ) { } = ! < > | : -
        // Doesn't include ' 
        $vlidatedvalue = str_replace("'", "\'", preg_quote($value[0]));
        //		print("<br/>key: ".$key." value: ".$value[0]." quoted: ".$vlidatedvalue."<br/>");	
        
        $query3  = "select tagid from tag where name = '" . $vlidatedvalue . "'";
        $result3 = pdo_prepare($query3);
        $result3->execute();
        $tagID               = $result3->fetch();
        $trimedtags[$key][1] = $tagID[0];
    }
    
    // 3) complete adding the set of recipeid + tagid into RECIPETAG table
    foreach ($trimedtags as $key => $value) {
        //		print("<br/>key: ".$key." value: ".$value[0]."<br/>");
        $query4  = "insert into recipeTag value(" . $currIDnum . ", '" . $value[1] . "')";
        $result4 = pdo_query($query4);
        
        if ($result4 == false) {
            print("Failed to add recipeID and tagID into recipeTag: " . mysql_error() . "<br />");
            return;
        }
    }
    
//   print("TAG SELECTED!!!<br/>");
    print("Succeed to create new recipe: ");
    print("<br /> ID: " . $currIDnum . "<br /> Name: " . $recipeName . "<br /> Resource: " . $resourceName . "<br /> Link: " . $resourceLink . "<br /> Tags: ");
    
    foreach ($trimedtags as $key => $value) {
        print($value[0] . ", ");
    }
      
} else if ($purpose == "change_recipe") {
    /*
    Change an existing recipe including id, name, resource name, resource link, and tags 
    */
    
    $origRecipe   = $_REQUEST["changeRecipeSelection"];
    $recipe       = $_REQUEST["change_recipename"];
    $resource     = $_REQUEST["change_resource"];
    $resourceLink = $_REQUEST["change_link"];
    
    $newtags = $_REQUEST["changeTagSelection"];
    
    try {
        pdo_transactionstart();
        
        $query0  = "select recipeid from recipe where name='" . $origRecipe . "'";
        $result0 = pdo_query($query0);
        $id      = $result0->fetch();
        
        $query1  = "update recipe set name='" . $recipe . "', resource='" . $resource . "', resourcelink='" . $resourceLink . "' where recipeid = " . $id[0];
        $result1 = pdo_query($query1);
        
        $query2  = "delete from recipeTag where recipeid =" . $id[0];
        $result2 = pdo_query($query2);
        
        for ($i = 0; $i < count($newtags); $i++) {
            $query3  = "insert into recipeTag values(" . $id[0] . ", '" . strtoupper($newtags[$i]) . "')";
            $result3 = pdo_query($query3);
        }
        
        pdo_commit();
        
        print("Succeed to update of recipe [ID: " . $id[0] . ", OLD Name: " . $origRecipe . "] ");
        print("<br /> NEW Name: " . $recipe . "<br /> NEW Resource: " . $resource . "<br /> NEW Link: " . $resourceLink);
        print("<br /> NEW Tags: ");
        
        foreach ($newtags as $tagid) {
            $query3  = "select name from tag where tagid ='" . $tagid . "'";
            $result3 = pdo_query($query3);
            $row     = $result3->fetch();
            
            print($row[0] . ", ");
        }
        
    }
    catch (Exception $e) {
        pdo_rollback();
        print("Error: " . $e);
    }
    
} else if ($purpose == "delete_recipe") {
    /*
    Delete recipe from RECIPE table, and also from RECIPETAG table
    Use atomic deletion	
    */
    $deleteName = $_REQUEST["deleteRecipeSelection"];
    
    $query1  = "select recipeid from recipe where name = '" . $deleteName . "'";
    $result1 = pdo_query($query1);
    
    $deleteID = $result1->fetch();
    
    try {
        pdo_transactionstart();
        
        $query2  = "delete from recipe where recipeid = " . $deleteID[0];
        $result2 = pdo_query($query2);
        
        $query3  = "delete from recipeTag where recipeid = " . $deleteID[0];
        $result3 = pdo_query($query3);
        
        pdo_commit();
        
        print("Succeed to delete recipe: ");
        print("<br /> ID: " . $deleteID[0] . "<br /> Name: " . $deleteName . "<br />");
        
    }
    catch (Exception $e) {
        pdo_rollback();
        print("Error: " . $e);
    }
} else if ($purpose == "create_tag") {
    /*
    Create new tag including id and name 
    */
    $tagName = $_REQUEST["new_tag"];
    //	print("@create tag: ".$tagName."<br />");
    
    $query0  = "select * from tag order by tagid desc limit 1";
    $result0 = pdo_query($query0);
    $lastID  = $result0->fetch();
    
    $lastDigit = substr($lastID[0], 1);
    $currDigit = $lastDigit + 1;
    
    $query1  = "insert into tag values('T" . $currDigit . "', '" . $tagName . "')";
    $result1 = pdo_query($query1);
    
    if ($result1 == false) {
        print("Failed to create tag data: " . mysql_error() . "<br />");
    } else {
        print("Succeed to create tag: ");
        print("<br /> ID: T" . $currDigit . "<br /> Name: " . str_replace("\\", "", $tagName) . "<br />");
    }
} else if ($purpose == "change_tag") {
    /*
    Change an existing tag including id and name 
    */
    $originalTag = $_REQUEST["changeTagSelection"];
    $changeTag   = $_REQUEST["change_tag"];
    
    $query  = "update tag set name='" . $changeTag . "' where name='" . $originalTag . "'";
    $result = pdo_query($query);
    if ($result == false) {
        print("Failed to update tag data: " . mysql_error() . "<br />");
    } else {
        print("Succeed to update tag: ");
        print("FROM (" . $originalTag . ") TO (" . $changeTag . ")<br />");
    }
} else if ($purpose == "delete_tag") {
    /*
    Delete tag from TAG table, and also from RECIPETAG table
    Use atomic deletion
    */
    $deleteName = $_REQUEST["deleteTagSelection"];
    
    $query0   = "select tagid from tag where name = '" . $deleteName . "'";
    $result0  = pdo_query($query0);
    $deleteID = $result0->fetch();
    
    try {
        pdo_transactionstart();
        
        $query1  = "delete from tag where tagid = '" . $deleteID[0] . "'";
        $result1 = pdo_query($query1);
        
        $query2  = "delete from recipeTag where tagid = '" . $deleteID[0] . "'";
        $result2 = pdo_query($query2);
        
        
        pdo_commit();
        
        print("Succeed to delete tag: ");
        print("<br /> ID: " . $deleteID[0] . "<br /> Name: " . str_replace("\\", "", $deleteName) . "<br />");
        
    }
    catch (Exception $e) {
        pdo_rollback();
        print("Error: " . $e);
    }
}
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
<?php
server_disconnect();
?>