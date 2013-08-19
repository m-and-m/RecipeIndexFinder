$(document).ready(function () {

    $("input#export").click(export_action);
    $("input#view").click(view_action);

});

function export_action() {
    var select = $("input:radio[name='filechoice']:checked").val();

    console.log("here i am at export_action: " + select);

    $.ajax({
        type: "GET",
        url: "../php/export_export.php?filename=" + select,
        //dataType: "xml",
        success: confirmation_msg,
        error: function () {
            alert("failed to fetch data table export-export");
        }
    });

} // export_action

function confirmation_msg(msg) {
    alert(msg);
} //confirmation_msg

function view_action() {
    // clear the content
    $("#table_content").empty();

    var select = $("input:radio[name='filechoice']:checked").val();

    console.log("here i am at view_action: " + select);

    $("hr#exportviewline").css("visibility", "visible");

    $.ajax({
        type: "GET",
        url: "../php/view_export.php?filename=" + select,
        dataType: "json",
        success: dumpTableContent,
        error: function () {
            alert("failed to fetch data table @view-export");
        }
    });

} // view_action

function dumpTableContent(content) {
    //	alert(JSON.stringify(content, null, "\t"));
    var html = "<table>";

    var firstitem = content[0];
    var totalcol = Object.keys(firstitem).length;
    var colcount = 0;

    for (var key in firstitem) {
        colcount++;
        switch (colcount) {
        case 1:
            html += "<thead><tr><th>&nbsp;" + key.toUpperCase() + "&nbsp;</th>";
            break;

        case totalcol:
            html += "<th>&nbsp;" + key.toUpperCase() + "&nbsp;</th></tr></thead>";
            break;

        default:
            html += "<th>&nbsp;" + key.toUpperCase() + "&nbsp;</th>";
            break;

        } // switch		
    } // for

    for (var idx = 0; idx < content.length; idx++) {

        var item = content[idx];
        var paircount = 0;

        for (var key in item) {

            //console.log(idx+": key: "+key+" value: "+item[key]);

            paircount++;

            switch (paircount) {
            case 1:
                html += "<tr><td>&nbsp;" + item[key] + "&nbsp;</td>";
                break;

            default:
                html += "<td>&nbsp;" + item[key] + "&nbsp;</td>";
                break;

            case totalcol:
                html += "<td>&nbsp;" + item[key] + "&nbsp;</td></tr>";
                break;
            } // switch

        } // inner for
    } // outer for

    html += "</table>";
    $("#table_content").append($(html));

} // dumpTableContent