function checkPass() {
	
	do {
		flag = false;
		pass = prompt("Got Password?");
		if(pass != "ofcourse!") {
			alert("Got wrong one! Sorry..try again.");
			flag = true;
		}
	
	} while (flag);
	 
} // checkPass

window.onload = function() {
	document.getElementById("createRecipeForm").onsubmit = checkNewRecipeName;
//constructing
	document.getElementById("selectButtonATchange").onclick = makeVisible;	
	document.getElementById("applyButtonATchange").onclick = checkChangeRecipeName;	
		
	document.getElementById("deleteRecipeForm").onsubmit = deleteRecipeMsg;

//constructing
	document.getElementById("createTagForm").onsubmit = checkNewTagName;
	
	document.getElementById("changeTagForm").onsubmit = checkChangeTagName;
	document.getElementById("deleteTagForm").onsubmit = deleteTagMsg;
};

function checkNewRecipeName() {
	return validate("recipeNewMUSTname","recipeSelect");
}

function checkChangeRecipeName() {
	return validateEmpty("changeName");
}

function checkNewTagName() {
	return validate("tagNewMUSTname","tagSelectChange");
}

function checkChangeTagName() {
	return validate("tagChangeMUSTname","tagSelectChange");
}

function deleteRecipeMsg() {
	return confirmation("recipeSelect");
}

function deleteTagMsg() {
	return confirmation("tagSelectDelete");
}

function makeVisible() {
	document.getElementById("changeName").style.visibility = "visible";
	document.getElementById("changeResource").style.visibility = "visible";
	document.getElementById("changeResourceLink").style.visibility = "visible";
	document.getElementById("applyButtonATchange").style.visibility = "visible";
	
	var recipe = document.getElementById("recipeSelect").value;
	var resourceResult = displayResource(recipe);
//	alert(resourceResult);
	var fieldElement = resourceResult.split("\|");
	
	document.getElementById("changeName").value = recipe;
	document.getElementById("changeResource").value = fieldElement[0];
	document.getElementById("changeResourceLink").value = fieldElement[1];
}

function displayResource(recipe) {
	var ajax = new XMLHttpRequest();
	ajax.open("GET", "edit_fetchResource.php?recipe="+recipe, false);
	ajax.send(null);
	
	if(ajax.status != 200) {
		alert("Error fetching text:\n"+ajax.status+" "+ajax.statusText);
	}
	
	return ajax.responseText;	
} // displayResource

/******************** COMMON FUNCTIONS ****************************/
/**
VALIDATE
**/
function validate(MUSTname, nameSelection) {
	//alert("@validate edit_library.js");
	
	var checkValue = document.getElementById(MUSTname).value;
	
	//Check the new recipe name is not "illegal"
	if(!isThisMyRegEx(checkValue)) {
		return false;
	}
	
	//Check the new recipe name is already taken.
	var allName = document.getElementById(nameSelection);
	for(indx = 0; indx < allName.length; indx++) {
		found = allName.options[indx].value.toLowerCase().indexOf(checkValue.toLowerCase());
		if(found == 0) {
			alert("'"+checkValue+"' is already taken.\n Use different name.");
			return false;
		}
	}

	return true;
} // validate

/**
VALIDATE ONLY empty string
**/
function validateEmpty(MUSTname) {
	//alert("@validateEmpty edit_library.js");
	
	var checkValue = document.getElementById(MUSTname).value;
	
	//Check the new recipe name is not "illegal"
	if(!isThisMyRegEx(checkValue)) {
		return false;
	}

	return true;
} // validateEmpty

/**
CONFIRMATION
**/
function confirmation(nameSelection) {
	//alert("@deleteRecipeMsg js_library");
	var deleteName = document.getElementById(nameSelection).value;
	decision = confirm("You are trying to delete: "+deleteName+"\n Are you sure?");

	return decision;
} // confirmation

function isThisMyRegEx(str) {
	var myRegex = new RegExp(/^[\"a-zA-Z0-9]/);
	
	if (str == "" || str == "\""){
		alert("Please fill the 'Recipe Name'!!");
		return false;
	} 
	
	//Check the string with my regular expression.
	//Return true - if the string satisfies myRegExp
	//		 false - if the string does not satisfy myRegExp		
	if (!myRegex.test(str)) {
		alert("Name MUST start with alphabet, number, or double quote\n"+
		      "Please try again.");
		return false;
	}
	
	return true;
} // isThisMyRegEx

/******************** UNUSED FUNCTIONS ***************************
	new Ajax.Request("edit_fetchResource.php",
	{
	 method: "get",
	 parameters: recipe;
	 onSuccess: displayResource;
	// onFailure: ajaxFailed;
	// onException: ajaxFailed;
	}
	);

function ajaxFailed(ajax, exception) {
	var msg = "Error making Ajax request:\n\n";
	if(exception){
		msg += "Exception: "+exception.message;
	} else {
		msg += "Server status:\n"+ajax.status+" "+ajax.statusText+
			   "\n\nServer response text:\n"+ajax.responseText;
	}
	
	alert(msg);
} // ajaxFailed
*/