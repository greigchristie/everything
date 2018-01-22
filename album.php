<?php
include("functions.php");
include("connected.php");
header('Content-Type:text/html; charset=UTF-8');
		$sqlc = "select count(id) from albums where album_owned = 1";
		//echo $sqlc;
		$resultc = mysqli_query($con,$sqlc);
		while ($row = mysqli_fetch_row($resultc))
		{
		$noalbums = $row[0];
		}
		$offset = 50;
		
		include("header.php");
?>

<h2>All <?php echo $noalbums ?> albums <small>(<?php echo $offset; ?> per page)</small></h2>

<?php
$nopages = round($noalbums / $offset);

//echo "Number of pages should be : ". $nopages;
if (isset($_GET['page'])){
$page = $_GET['page'];
} else {
$page = 1;
}
if ($page > $nopages) {
echo "whoa nelly, no such page!";
} else {
$prevpage = $page - 1;


$top = $page * 100;
$bottom = $prevpage * $offset;
echo pubpag($page, $noalbums, $heres, $offset);
?>

<p class="lead">Album</p>
<?php
//Just to see what comments look like!
		$sql = "select a.artist_name, b.id, b.album_title, b.album_collection";
		$sql = $sql . " from artists a, albums b";
		$sql = $sql . " where a.id = b.album_artist_id";
		$sql = $sql . " and b.album_owned = 1";
		$sql = $sql . " order by b.album_title";
		$sql = $sql . " LIMIT $offset offset $bottom";
//		echo $sql;
		$result = mysqli_query($con,$sql);
		$row_cnt = mysqli_num_rows($result);
		while ($row = mysqli_fetch_array($result))
		{
//		print_r($row);
		//$trackartist = $row['trackartist'];
		//$trackname = $row['trackname'];
		$trackalbum = $row['album_title'];
		$albumid = $row['id'];
		$albumartist = $row['artist_name'];
		$albumcollection = $row['album_collection'];
		//$utrackartist = urlencode($trackartist);
		//$utrackname = urlencode($trackname);
		$utrackalbum = urlencode($trackalbum);
			echo "<div id ='row'>";
			echo "<div id='col-xs-8'>";
			echo "<p><a href='albumview.php?req=albumid&query=$albumid'>$trackalbum</a> - $albumartist ($albumcollection) <i class=\"fa fa-plus-square\" style='font-size: 12pt;' onclick='showUser($albumid)' id='openList$albumid'></i><i class=\"fa fa-minus-square\" style='font-size: 12pt; display: none;' onclick='hideDiv($albumid)' id='closeList$albumid'></i></p>";
			echo "<div class='row'><div class='col-xs-12' id='trackCon$albumid'></div></div>\n";
			//echo "<td>" . $trackname . "</td> ";
			//echo "<td>" . $trackalbum . "</td> ";
			echo "</div>\n";
			echo "</div>\n";
		}
	}//nelly	
?>


<?php
echo totop($row_cnt);
echo pubpag($page, $noalbums, $heres, $offset);
?>

<?php
include("footer.php");
?>

