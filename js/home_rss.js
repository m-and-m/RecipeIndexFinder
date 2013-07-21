var days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Nov", "Dec"];

var MyGlobal = {
    totalCnt: 0,
    currIdx: 0,
    numXML: 0,
    arrayXMLs: [],
    xmlinfo: new Array()
}

window.onload = function () {

    fetchRSSfeed();
    // refresh page every 30 mins
    setTimeout(fetchRSSfeed, 300000);
};

function fetchRSSfeed() {

    var i;

    /** get xml list to access **/
    var xmls = $("span#xml").text();

    MyGlobal.arrayXMLs = xmls.split(",");
    MyGlobal.numXML = MyGlobal.arrayXMLs.length - 1;

    /**	clear the content in the div for the next feed **/
    $("#rss_content").empty();

    /** start accessing each xml **/
    callAjax();

} // fetchRSSfeed

function callAjax() {

    $.ajax({
        type: "GET",
        url: "../php/proxy.php?xml=" + MyGlobal.arrayXMLs[MyGlobal.currIdx],
        dataType: "xml",
        success: parseResult,
        error: function () {
            alert("failed to access to xml file @home_rss.js");
        }
    });

} // callAjax

function parseResult(data) {

    var prCnt = 0;
    
    	
	var siteTitle = $(data).find("channel").children("title").text();
    
    // parse elements for a xml		
    $(data).find("item").each(function (index) {

        // the current section of the content
        var $item = $(this);
        // the title
        var title = $item.find("title").text();
        // skip advertisements from Japanese site
        if (title.indexOf("PR:") == 0) {
            prCnt++;
            return true;
        }
        // the url
        var link = $item.find("link").text();
        // the pubdate
        var pubDate = $item.find("pubDate").text(); 
        var new_pubDate = new Date(pubDate);

       
/*
console.log(pubDate+"\n");
console.log(new_pubDate+"\n");
console.log("--->");
*/
        MyGlobal.xmlinfo[MyGlobal.totalCnt] = new Array();
        // "index-prCnt": recalculating index (considering skip PR posts) 
        MyGlobal.xmlinfo[MyGlobal.totalCnt].push(index - prCnt, title, link, new_pubDate, siteTitle);

        MyGlobal.totalCnt++;

    });

    MyGlobal.currIdx++;

    if (MyGlobal.currIdx < MyGlobal.numXML) {
        callAjax();
    } else {

        sortByDate(MyGlobal.xmlinfo);
        dumpData(MyGlobal.xmlinfo);
    }
} // parseResult

function sortByDate(array2d) {

    var begin2ndFeed;
    var rslt;
    var tmp;

    // skip first "0"
    for (var i = 1; i < array2d.length; i++) {
        if (array2d[i][0] == 0) {
            begin2ndFeed = i;
            break;
        }
    }

    console.log("index of the beginning of 2nd feed" + begin2ndFeed);

    while (array2d[begin2ndFeed] != null) {

        var curr = begin2ndFeed - 1;

        while (array2d[curr] != null) {

            rslt = compareDates(array2d[begin2ndFeed], array2d[curr]);

            if (rslt == 1 && curr == 0) {

                console.log("insert (" + array2d[begin2ndFeed][3] + ") at the top of (" + array2d[curr][3] + ")");

                array2d.splice(curr, 0, array2d[begin2ndFeed]);
                array2d.splice(begin2ndFeed + 1, 1);

                break;

            } else if (rslt == 1 && curr != 0) {

                curr--;

            } else if (rslt == -1) {

                console.log("insert (" + array2d[begin2ndFeed][3] + ") after (" + array2d[curr][3] + ")");

                array2d.splice(curr + 1, 0, array2d[begin2ndFeed]);
                array2d.splice(begin2ndFeed + 1, 1);

                break;
            }
        } // inner while

        begin2ndFeed++;

    } // outer while
} // sortByDate

function compareDates(c1, c2) {
    // c1: 2ndfeed, c2: curr
    var rslt;

    if (c1[3].getTime() > c2[3].getTime()) { // curr is older than 2ndfeed => skip
        rslt = 1;
    } else if (c1[3].getTime() < c2[3].getTime()) { // curr is newer => insert 2ndfeed after curr
        rslt = -1;
    } else { // same old: do nothing
        rslt = 0;
    }

    console.log("2nd feed (" + c1[3] + "), curr (" + c2[3] + ") : rslt (" + rslt + ")");
    return rslt;
} // compareDates

function dumpData(array2d) {
//OK     console.log(array2d);

    var index = 0;
    var html = "";
    var a2d;
	var formedDate;
	
    while ( array2d[index] != null) {
		var post = array2d[index];

        /*
		[1]: title
		[2]: link
		[3]: date
		[4]: site title
		*/

		formedDate = reformingDate(post);

        // the html to output the feed to the browser window
        if (index % 2 == 0) {

            html += "<tr id='odd'><td><a href='" + post[2] + "'>" + post[1] + "</a>";
            html += "&nbsp;&nbsp;&nbsp;&nbsp;<span id='siteTitle'>"+ post[4] + "</span>&nbsp;&nbsp;&nbsp;&nbsp;";
            html += "<span id='datepost'>" + formedDate + "&nbsp;&nbsp;&nbsp;&nbsp;<br/></span></td></tr>";

        } else if (index % 2 == 1) {

            html += "<tr id='even'><td><a href='" + post[2] + "'>" + post[1] + "</a>";
            html += "&nbsp;&nbsp;&nbsp;&nbsp;<span id='siteTitle'>"+ post[4] + "</span>&nbsp;&nbsp;&nbsp;&nbsp;";
        	html += "<span id='datepost'>" + formedDate + "<br/></span></td></tr>";
        }

        index++;
    }

    //put that feed content on the screen
    $("#rss_content").append($(html));

} // dumpData

function reformingDate(onePost) {

    var dayIdx = onePost[3].getDay();
    var monthIdx = onePost[3].getMonth();
    var date = onePost[3].getDate();
    var year = onePost[3].getFullYear();
    var hour = onePost[3].getHours();
    var min = onePost[3].getMinutes();
    var sec = onePost[3].getSeconds();

    var new_pubDate = days[dayIdx] + " " + months[monthIdx] + " " + date + " " + year + " ";
        new_pubDate += hour + ":" + min + ":" + sec;

    return new_pubDate;
    
} // reformingDate