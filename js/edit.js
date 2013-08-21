$(document).ready(function () {
	// drop down check list with initial empty option
	$("#deleteRecipeSelect").prop("selectedIndex", -1);
	$("#tagSelectChange").prop("selectedIndex", -1);
	$("#tagSelectDelete").prop("selectedIndex", -1);

    // create recipe
    document.getElementById("createRecipeForm").onsubmit = checkNewRecipeName;
    // change recipe
    document.getElementById("recipeSelect").onchange = makeInvisible;
    document.getElementById("selectButtonATchange").onclick = makeVisible;
    document.getElementById("applyButtonATchange").onclick = checkChangeRecipeName;
    document.getElementById("cancelButtonATchange").onclick = makeInvisible;
    // delete recipe
    document.getElementById("deleteRecipeForm").onsubmit = deleteRecipeMsg;

    // create tag
    document.getElementById("createTagForm").onsubmit = checkNewTagName;
    // change tag
    document.getElementById("changeTagForm").onsubmit = checkChangeTagName;
    // delete tag
    document.getElementById("deleteTagForm").onsubmit = deleteTagMsg;

    // add tags
    $("#addTags").dropdownchecklist({
        maxDropHeight: 200,
        width: 300,
        textFormatFunction: function (options) {
            var selectedOptions = options.filter(":selected");
            var countOfSelected = selectedOptions.size();
            var size = options.size();
            switch (countOfSelected) {
           		case 0:
                	return "Add tags?";
            	case 1:
                	return selectedOptions.text();
            	default:
                	return countOfSelected + " Tags";
            }
        },
        onComplete: function (selector) {
            var values = "";
            for (i = 0; i < selector.options.length; i++) {
                if (selector.options[i].selected && (selector.options[i].value != "")) {
                    values += selector.options[i].value + ";";
                }
            }
        }
    });

});

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
	return confirmation("deleteRecipeSelect");
}

function deleteTagMsg() {
	return confirmation("tagSelectDelete");
}

function makeVisible() {
	document.getElementById("changeName").style.visibility = "visible";
	document.getElementById("changeResource").style.visibility = "visible";
	document.getElementById("changeResourceLink").style.visibility = "visible";
	document.getElementById("changeTagMemo").style.display = "inline";
	document.getElementById("changeTagSelect").style.display = "block";
	document.getElementById("applyButtonATchange").style.visibility = "visible";
	document.getElementById("cancelButtonATchange").style.visibility = "visible";
	
	
	// get recipe name from drop down checklist
	var recipe = document.getElementById("recipeSelect").value;
	// get all information about the recipe
	var resourceResult = displayResource(recipe);
	
	console.log("fetch the all info about the recipe through ajax...\n");
	console.log(resourceResult);

	var fieldElement = resourceResult.split("\|");
	/* 
	   fieldElement[0]: resource name
	   fieldElement[1]: resource link
	   fieldElement[2+]: tag ids
	*/
	
	//alert(fieldElement);

	document.getElementById("changeName").value = recipe;
	document.getElementById("changeResource").value = fieldElement[0];
	document.getElementById("changeResourceLink").value = fieldElement[1];

	// set pre-select
	if(fieldElement[2] != null) {
		var countTag = 2;
		while(fieldElement[countTag]) {
			var tagID = fieldElement[countTag];
			$("#changeTagSelect option[value='" + tagID.toLowerCase() + "']").attr("selected", true);
//			console.log("from option value: "+$("#changeTagSelect option[value=" + tagID + "]").val());
			countTag++;
		}
	}
	
} // makeVisible

function js_preg_quote (str) {
	return (str + "").replace(new RegExp("[.\\\\+*?\\[\\^\\]$(){}=!<>|:\\-]", "g"), "\\$&");
} // js_preg_quote

function makeInvisible() {
	document.getElementById("changeName").style.visibility = "hidden";
	document.getElementById("changeResource").style.visibility = "hidden";
	document.getElementById("changeResourceLink").style.visibility = "hidden";
	document.getElementById("changeTagMemo").style.display = "none";
	document.getElementById("changeTagSelect").style.display = "none";
	document.getElementById("applyButtonATchange").style.visibility = "hidden";
	document.getElementById("cancelButtonATchange").style.visibility = "hidden";
	
	// clear the selected option of selection
	// no	document.getElementById("changeTagSelect").selectedIndex = 0;
	document.getElementById("changeTagSelect").options.length= 0;

	location.reload();
} // makeInvisible

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
		if(allName.options[indx].value.toLowerCase() == checkValue.toLowerCase()) {
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

*/