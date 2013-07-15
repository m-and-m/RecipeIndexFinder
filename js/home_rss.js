var days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Nov", "Dec"];

window.onload = function() {
	fetchRSSfeed();
};

function fetchRSSfeed() {
 
	//	$.get("../php/proxy.php", function(data){	
	$.ajax({
		type: "GET",
		url: "../php/proxy.php",
		dataType: "xml",
		success:function(data){

			//clear the content in the div for the next feed.
			$("#rss_content").empty();
			
			//var index = 0;
			
			$(data).find("item").each(function(index) {
 
			// the current section of the content
			var $item = $(this);

			// the title
			var title = $item.find("title").text();

			// the url
			var link = $item.find("link").text();
			
			// the pubdate
			var pubDate = $item.find("pubDate").text();
			// reformat pubdate
			var formatedDate = new Date(pubDate);
			/*
			var dayIdx = formatedDate.getDay();
			var monthIdx = formatedDate.getMonth();
			var date = formatedDate.getDate();
			var year = formatedDate.getFullYear();
			var hour = formatedDate.getHours();
			var min = formatedDate.getMinutes();
			var sec = formatedDate.getSeconds();
			
			var new_pubDate = days[dayIdx]+" "+months[monthIdx]+" "+date+" "+year+" ";
			new_pubDate += hour+":"+min+":"+sec;
			*/
			
			// the html to output the feed to the browser window
			if(index%2 == 0) {
			
				var html = "<tr id='even'><td><a href="+link+">"+title+"</a>";
				html +="<span id='datepost'>&nbsp;&nbsp;&nbsp;&nbsp;"+formatedDate;
				html+= "&nbsp;&nbsp;&nbsp;&nbsp;<br/></span></td></tr>";
				//html += "DESCRIPTION: "+description+"<br/></p>";	
			
			} else if (index%2 == 1){
			
				var html = "<tr id='odd'><td><a href="+link+">"+title+"</a>";
				html +="<span id='datepost'>&nbsp;&nbsp;&nbsp;&nbsp;"+formatedDate;
				html+= "&nbsp;&nbsp;&nbsp;&nbsp;<br/></span></td></tr>";
				//html += "DESCRIPTION: "+description+"<br/></p>";		
			}
			
			//put that feed content on the screen
			$("#rss_content").append($(html)); 
			});
			
		},
		error: function(){
			alert("error");
		}
	});
	
} // fetchRSSfeed