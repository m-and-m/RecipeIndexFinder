var MyGlobal2 = {
    feedxml: ""
}

$(document).ready(function() {

	$("span#addcnt").click(add_action);
	$("img.rmvcnt").click(rmv_action);
	
});

/****************************** ADD RSS FEED ******************************/

function add_action() {
	
	MyGlobal2.feedxml = prompt("Enter feed URL. This program supports only rss ver. 2.0");
//OK	alert(MyGlobal2.feedxml);
	if(MyGlobal2.feedxml != null) {
    $.ajax({
        type: "GET",
        url: "../php/proxy.php?xml=" + MyGlobal2.feedxml,
        dataType: "xml",
        success: validateRSS,
        error: function () {
            alert("failed to access to xml file @rssfeed_sitesmgmt.js");
        }
    });
	}

} // add_action

function validateRSS(data) {
//OK console.log(data);
	var version = $(data).find("rss").attr("version");
	
	if(version != "2.0" || version == null){
		alert(version+"   Sorry :(  You cannot subscribe this site... It's not rss ver. 2.0");
		return null;
	} 
	
	var feedtitle = $(data).find("channel").children("title").text();
	var feedurl = $(data).find("channel").children("link").text();

 //OK alert(feedtitle+"  "+feedurl);
		 
    $.ajax({
        type: "GET",
        url: "../php/rssfeed_addURL.php?rssname="+feedtitle+"&rssurl=" + feedurl+"&rssxml="+MyGlobal2.feedxml,
        /*
        url: "../php/info.php?rssname="+feedtitle+"&rssurl=" + feedurl+"&rssxml="+MyGlobal2.feedxml,
        */
        success: confirmation,
        error: function () {
            alert("failed to access to php file @rssfeed_addURLs.js");
        }
    });
    	 
} // validateRSS

/****************************** REMOVE RSS FEED ******************************/
function rmv_action() {

var siteid = $(this).parent().children("span#siteid").text();
var sitename = $(this).parent().children("a.selectname").text();
//var siteurl = $(this).parent().children("a.selectname").attr("href");
	alert(siteid);
	    $.ajax({
        type: "GET",
        url: "../php/rssfeed_rmvURL.php?siteid="+siteid+"&rssname="+sitename,
        success: confirmation,
        error: function () {
            alert("failed to access to php file @rssfeed_sitemgmt.js");
        }
    });
} // rmv_action

/****************************** SHARE FUNCTION ******************************/

function confirmation(conf) {
	alert(conf);
	location.reload();
}
