<?php
// this code makes the display utf-8 compliant and the $here stuff means page context code can be used.
header('Content-Type:text/html; charset=UTF-8');
$here = $_SERVER['PHP_SELF'];
//echo $here;
//$here = str_replace('/everything/live', '', $here); //local
//$here = str_replace('/everything', '', $here); //live
 $here = str_replace('/sites/new', '', $here); //linux
$heres = str_replace('/', '', $here);
$heres = str_replace('.php', '', $heres);


// function that handles pagination
function pubpag($page, $noalbums, $heres, $offset) {

$nopages = ceil($noalbums / $offset);
$prevpage = $page - 1;
$nextpage = $page + 1;
$minuspage = $page - 10;
$pluspage = $page + 10;
//$heres = str_replace('/', '', $heres);
//echo $heres;
echo "<div class='row'>\n";
echo "<div class='col-xs-12 col-md-8 col-lg-8'>\n";
echo "\n<ul class='nav pagination pagination-sm'>";
if ($page == 1) {
echo "<li class='first-child disabled'><a href='$heres.php?page=1'><span class='glyphicon glyphicon-fast-backward' aria-hidden='true'></span></a></li>\n";
echo "<li class='disabled'><a href='$heres.php?page=".$minuspage."'><span class='glyphicon glyphicon-backward' aria-hidden='true'></span> 10</a></li>\n";
echo "<li class='disabled'><a href='$heres.php?page=$prevpage'><span class='glyphicon glyphicon-backward' aria-hidden='true'></span></a></li>\n";
 }
if ($page < 11 && $page > 1) {
echo "<li class='first-child'><a href='$heres.php?page=1'><span class='glyphicon glyphicon-fast-backward' aria-hidden='true'></span></a></li>\n";
echo "<li class='disabled'><a href='$heres.php?page=".$minuspage."'><span class='glyphicon glyphicon-backward' aria-hidden='true'></span> 10</a></li>\n";
echo "<li><a href='$heres.php?page=$prevpage'><span class='glyphicon glyphicon-backward' aria-hidden='true'></span></a></li>\n";
 }
if ($page > 10){
echo "<li><a href='$heres.php?page=1'><span class='glyphicon glyphicon-fast-backward' aria-hidden='true'></span></a></li>\n";	
echo "<li><a href='$heres.php?page=".$minuspage."'><span class='glyphicon glyphicon-backward' aria-hidden='true'></span> 10</a></li>\n";
echo "<li class=><a href='$heres.php?page=$prevpage'><span class='glyphicon glyphicon-backward' aria-hidden='true'></span></a></li>\n";
}
echo "<li class=\"active\"><a href=''>".$page."</a></li>\n";
if ($page == $nopages) {
echo "<li class='disabled'><a href='$heres.php?page=$nextpage'><span class='glyphicon glyphicon-forward' aria-hidden='true'></span></a></li>\n";
echo "<li class='disabled'><a href='$heres.php?page=".$pluspage."'>10 <span class='glyphicon glyphicon-forward' aria-hidden='true'></span></a></li>\n";
echo "<li class='last-child disabled'><a href='$heres.php?page=$nopages'><span class='glyphicon glyphicon-fast-forward' aria-hidden='true'></span></a></li>\n";
} 
if ($page < $nopages && $page < $nopages - 9) {
echo "<li><a href='$heres.php?page=$nextpage'><span class='glyphicon glyphicon-forward' aria-hidden='true'></span></a></li>\n";
echo "<li><a href='$heres.php?page=".$pluspage."'>10 <span class='glyphicon glyphicon-forward' aria-hidden='true'></span></a></li>\n";
echo "<li class='last-child'><a href='$heres.php?page=$nopages'><span class='glyphicon glyphicon-fast-forward' aria-hidden='true'></span></a></li>\n";
} 
if ($page > $nopages -10 && $page != $nopages) {
echo "<li><a href='$heres.php?page=$nextpage'><span class='glyphicon glyphicon-forward' aria-hidden='true'></span></a></li>\n";
echo "<li class='disabled'><a href='$heres.php?page=".$pluspage."'>10 <span class='glyphicon glyphicon-forward' aria-hidden='true'></span></a></li>\n";
echo "<li class='last-child'><a href='$heres.php?page=$nopages'><span class='glyphicon glyphicon-fast-forward' aria-hidden='true'></span></a></li>\n";	
}
echo "</ul>\n";
echo "</div>\n";
echo "</div>\n";
}

// function that inserts a button jumping user back to the top of the page if the number of results on screen means you will scroll off nav menu
function totop($row_cnt) {
if ($row_cnt > 19) {
	echo "<div id='row'\n";
	echo "\n<p>&nbsp;</p>\n";
	echo "<button type=\"button\" class=\"btn btn-danger\" aria-label=\"To top\" onclick=\"scrollWin()\"><span class=\"glyphicon glyphicon-chevron-up\" aria-hidden=\"true\"></span></button>\n";
	echo "<script>\n";
	echo "function scrollWin() {\n";
	echo "    window.scrollTo(0, 0);\n";
	echo "}\n";
	echo "</script>\n";
	echo "</div>\n";
	}
	}
?>