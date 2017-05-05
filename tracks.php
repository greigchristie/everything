<?php
include("functions.php");
include("connected.php");

		$sqlc = "select count(c.id) from albums b, tracks c where b.id = c.album_id and b.album_owned = 1";
		//echo $sqlc;
		$resultc = mysqli_query($con,$sqlc);
		while ($row = mysqli_fetch_row($resultc))
		{
		$notracks = $row[0];
		}
		$offset = 50;
$page = "1";
$noalbums = $notracks;
		$sort = "track_title";
if (isset($_GET['sort'])){
$sort = $_GET['sort'];
}
if (isset($_GET['page'])){
$page = $_GET['page'];
}
include("header.php");
?>



<h2>All <?php echo $notracks." tracks (". $offset ." ";?>per page)</h2>

<?php


$nopages = ceil($notracks / $offset);

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
 <div class="row">
 <div class="col-xs-12 col-md-10 col-lg-8">

 <table class="table table-striped table-responsive">
<thead>
<tr>
<th><a href="tracks.php?sort=artist_name&page=<?php echo $page ?>">Artist</a></th>
 
<th><a href="tracks.php?sort=track_title&page=<?php echo $page ?>">Track</a></th>
 
<th><a href="tracks.php?sort=album_title&page=<?php echo $page ?>">Album</a></th>
 
<th></th>
</tr>
</thead>
 
<tbody>
<?php

//Just to see what comments look like!
		$sql = "SELECT a.artist_name, b.id, b.album_collection, b.album_title, c.track_title, c.track_artist_id";
		$sql = $sql . " FROM artists a, albums b, tracks c";
		$sql = $sql . " WHERE a.id = c.track_artist_id";
		$sql = $sql . " AND b.id = c.album_id";
		$sql = $sql . " AND b.album_owned = 1";
		$sql = $sql . " ORDER BY $sort asc";
		$sql = $sql . " LIMIT $offset offset $bottom";

		// echo $sql;
		$result = mysqli_query($con,$sql);
		$row_cnt = mysqli_num_rows($result);
		while ($row = mysqli_fetch_array($result))
		{
		$trackartist = $row['artist_name'];
		$trackname = $row['track_title'];
		$trackalbum = $row['album_title'];
		$albumid = $row['id'];
		$artistid = $row['id'];
		$collection = $row['album_collection'];
		$utrackartist = urlencode($trackartist);
		$utrackname = urlencode($trackname);
		$utrackalbum = urlencode($trackalbum);
			echo "<tr>";
			echo "<td><a href='refined.php?req=trackartist&query=$artistid'>$trackartist</a></td>";
			echo "<td><a href='refined.php?req=tracktitle&query=$utrackname'>$trackname</a></td>";
			echo "<td><a href='refined.php?req=albumtitle&query=$albumid'>$trackalbum</a> (".$collection.")</td>";
			//echo "<td>" . $trackname . "</td> ";
			//echo "<td>" . $trackalbum . "</td> ";
			echo "</tr>\n";
		}
	} //nelly	
?>
</tbody>
</table>
</div>
</div>
<?php
echo totop($row_cnt);
echo pubpag($page, $noalbums, $heres, $offset);
include("footer.php");
?>
