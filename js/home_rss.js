var days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Nov", "Dec"];


window.onload = function () {

    fetchRSSfeed();
};

function fetchRSSfeed() {

/** get xml list to access **/
    var xmls = $("span#xml").text();

    var arrayXMLs = xmls.split(",");
    var numXML = arrayXMLs.length;
/*
    console.log(xmls);
    console.log(arrayXMLs.length);
*/

/**	clear the content in the div for the next feed **/
    $("#rss_content").empty();

/** start accessing each xml **/
    for (var i = 0; i < numXML - 1; i++) {

        $.ajax({
            type: "GET",
            url: "../php/proxy.php?xml=" + arrayXMLs[i],
            dataType: "xml",
            success: function (data) {

                // reset the counting post for new site
                var index = 0;
                var html;

                // parse elements for a xml		
                $(data).find("item").each(function () {

                    // the current section of the content
                    var $item = $(this);

                    // the title
                    var title = $item.find("title").text();

                    // skip advertisements from Japanese site
                    if (title.indexOf("PR:") == 0) {
                        return true;
                    }

                    // the url
                    var link = $item.find("link").text();

                    // the pubdate
                    var pubDate = $item.find("pubDate").text();
                    // reformated pubdate
                    var formatedDate = new Date(pubDate);

                    // the html to output the feed to the browser window
                    if (index % 2 == 0) {

                        html = "<tr id='even'><td><a href=" + link + ">" + title + "</a>";
                        html += "<span id='datepost'>&nbsp;&nbsp;&nbsp;&nbsp;" + formatedDate;
                        html += "&nbsp;&nbsp;&nbsp;&nbsp;<br/></span></td></tr>";
                        //html += "DESCRIPTION: "+description+"<br/></p>";	

                    } else if (index % 2 == 1) {

                        html = "<tr id='odd'><td><a href=" + link + ">" + title + "</a>";
                        html += "<span id='datepost'>&nbsp;&nbsp;&nbsp;&nbsp;" + formatedDate;
                        html += "&nbsp;&nbsp;&nbsp;&nbsp;<br/></span></td></tr>";
                        //html += "DESCRIPTION: "+description+"<br/></p>";		
                    }

                    index++;

                    //put that feed content on the screen
                    $("#rss_content").append($(html));

                });
            },
            error: function () {
                alert("failed to access to xml file @home_rss.js");
            }
        });
    } // end of for loop

} // fetchRSSfeed

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

