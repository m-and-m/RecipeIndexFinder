window.onload = function() {
	document.getElementById("keyRecipeSearch").onsubmit = checkRecipeKey;
	document.getElementById("keyTagSearch").onsubmit = checkTagKey;

};

function checkRecipeKey() {
	var checkRecipeKey = document.getElementById("recipeKeyMUSTname").value;

	if (checkRecipeKey == ""){
		alert("Please fill the keyword!!");
		return false;
	} 
	
	return true;
} // checkRecipeKey

function checkTagKey() {
	var checkTagKey = document.getElementById("tagKeyMUSTname").value;

	if (checkTagKey == ""){
		alert("Please fill the keyword!!");
		return false;
	} 
	
	return true;
} // checkTagKey