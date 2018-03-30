<?php
include("functions.php");
include("connected.php");
		$sqlc = "select count(distinct(a.id))";
		$sqlc = $sqlc . " from artists a, albums b, tracks c";
		$sqlc = $sqlc . " where a.id = c.track_artist_id";
		$sqlc = $sqlc . " and b.id = c.album_id";
		$sqlc = $sqlc . " and b.album_owned = 1";
		//echo $sqlc;
		$resultc = mysqli_query($con,$sqlc);
		while ($row = mysqli_fetch_row($resultc))
		{
		$noalbums = $row[0];
		}
	include("header.php");
	$offset = 35;
?>

<h2>All <?php echo $noalbums ?> artists <small>(<?php echo $offset; ?> per page)</small></h2>

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
		$sql = "select a.id, a.artist_name";
		$sql = $sql . " from artists a, albums b, tracks c";
		$sql = $sql . " where a.id = c.track_artist_id";
		$sql = $sql . " and b.id = c.album_id";
		$sql = $sql . " and b.album_owned = 1";
		$sql = $sql . " group by a.id";
		$sql = $sql . " order by a.artist_name";
		$sql = $sql . " LIMIT $offset offset $bottom";
		//$sql = $sql . " group by trackartist";
		$result = mysqli_query($con,$sql);
		$row_cnt = mysqli_num_rows($result);
		while ($row = mysqli_fetch_array($result))
		{
		$artistid = $row['id'];
		$trackartist = $row['artist_name'];
		//$trackname = $row['trackname'];
		//$trackalbum = $row['trackalbum'];
		$utrackartist = urlencode($trackartist);
		//$utrackname = urlencode($trackname);
		//$utrackalbum = urlencode($trackalbum);
			echo "<div id ='row'>";
			echo "<div id='col-xs-8'><p><a href='search.php?artistidquery=$artistid'>$trackartist</a> - <a href='artistview.php?artist=$artistid'>View Albums</a> - <a href='artistedit.php?artist=$artistid'>Edit</a></p></div>";
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

include("footer.php");
?>
