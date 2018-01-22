<?php
include("functions.php");
include("connected.php");
		$sqlc = "select count(distinct(album_artist_id)) from albums";
		//echo $sqlc;
		$resultc = mysqli_query($con,$sqlc);
		while ($row = mysqli_fetch_row($resultc))
		{
		$noalbums = $row[0];
		}
	include("header.php");
	$offset = 35;
?>

<h2>All <?php echo $noalbums ?> album artists <small>(<?php echo $offset; ?> per page)</small></h2>

<?php


$nopages = ceil($noalbums / $offset);

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

<p class="lead">Artist</p>
<?php

//Just to see what comments look like!
		$sql = "SELECT album_artist_name, album_artist_id FROM artists a, albums b";
		$sql = $sql . " where a.id = b.album_artist_id";
		$sql = $sql . " group by album_artist_id, album_artist_name";
		$sql = $sql . " order by a.artist_sort_name";
		$sql = $sql . " LIMIT $offset offset $bottom";
		//$sql = $sql . " group by trackartist";
//		echo $sql;
		$result = mysqli_query($con,$sql);
		$row_cnt = mysqli_num_rows($result);
		while ($row = mysqli_fetch_array($result))
		{
		$albumartist = $row['album_artist_name'];
		$artistid = $row['album_artist_id'];
		//$trackname = $row['trackname'];
		//$trackalbum = $row['trackalbum'];
		$ualbumartist = urlencode($albumartist);
		//$utrackname = urlencode($trackname);
		//$utrackalbum = urlencode($trackalbum);
			echo "<div id ='row'>";
			echo "<div id='col-xs-8'><p><a href='artistview.php?artist=$artistid'>$albumartist</a></p></div>";
			//echo "<td><a href='refined.php?req=trackname&query=$utrackname'>$trackname</a></td>";
			//echo "<td><a href='refined.php?req=trackalbum&query=$utrackalbum'>$trackalbum</a></td>";
			//echo "<td>" . $trackname . "</td> ";
			//echo "<td>" . $trackalbum . "</td> ";
			echo "</div>\n";
		}
		} // nelly?
?>
</tbody>
</table>

<?php
echo totop($row_cnt);
echo pubpag($page, $noalbums, $heres, $offset);
?>

<?php
include("footer.php");
?>
