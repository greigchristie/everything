function showUser(str) {
    if (str == "") {
        document.getElementById("trackCon").innerHTML = "trackCon";
        return;
    } else {

            
        xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("trackCon"+str).style.display = 'inline';
                document.getElementById("openList"+str).style.display = 'none';
                document.getElementById("closeList"+str).style.display = 'inline';
                document.getElementById("trackCon"+str).innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","gettracks.php?q="+str,true);
        xmlhttp.send();
//        return xmlhttp;
    }
}

function hideDiv(target) {
document.getElementById("trackCon"+target).style.display = 'none';
                document.getElementById("openList"+target).style.display = 'inline';
                document.getElementById("closeList"+target).style.display = 'none';
}

	$(function() {
	if ( $( "li.al-itunes" ).length && $( "li.al-dlibrary" ).length) {
		var m = $( "li.al-dlibrary" ).length;
		$( "small.olalbums" ).append( "<strong> - " + m + " physical albums and </strong>");
 		var n = $( "li.al-itunes" ).length;
		$( "small.olalbums" ).append( "<strong>" + n + " digital albums</strong>");
 	}

	if ( $( "li.al-coverdisc" ).length && $( "li.al-dlibrary" ).length) {
		var o = $( "li.al-dlibrary" ).length;
		$( "small.olalbums" ).append( "<strong> - " + o + " physical albums and </strong>");
 		var p = $( "li.al-coverdisc" ).length;
		$( "small.olalbums" ).append( "<strong>" + p + " coverdisc albums</strong>");
 	}
	});