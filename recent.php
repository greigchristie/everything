<?php
include("functions.php");
include("connected.php");

		$sqlc = "select count(c.id) from albums b, tracks c where b.id = c.album_id and b.album_owned = 1";
		//echo $sqlc;
		$resultc = mysqli_query($con,$sqlc);
		while ($row = mysqli_fetch_row($resultc))
		{
		$noalbums = $row[0];
		}
include("header.php");
?>
 <div class="row">
 <div class="col-xs-12 col-md-10 col-lg-8">
 <h2>All tracks, recent additions first</h2>

<?php
$offset = 50;

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

<table class="table table-striped">
<thead>
<tr>
<th>Artist</th>
<th>Track</th>
<th>Album</th>
 

</tr>
</thead>
 
<tbody>
<?php

//Just to see what comments look like!
		$sql = "SELECT a.artist_name, b.album_title, c.track_title, b.id, a.id as artist_id  FROM artists a, albums b, tracks c";
		$sql = $sql." where a.id = c.track_artist_id";
		$sql = $sql."  and b.id = c.album_id";
		$sql = $sql."  and b.album_owned = 1";
		$sql = $sql . " order by c.id desc";
		$sql = $sql . " LIMIT $offset offset $bottom";
		// echo $sql;
		//$sql = $sql . " group by trackartist";
		$result = mysqli_query($con,$sql);
		$row_cnt = mysqli_num_rows($result);
		while ($row = mysqli_fetch_array($result))
		{
		$trackartist = $row['artist_name'];
		$trackname = $row['track_title'];
		$trackalbum = $row['album_title'];
		$albumid = $row['id'];
		$artistid = $row['artist_id'];
		$utrackartist = urlencode($trackartist);
		$utrackname = urlencode($trackname);
		$utrackalbum = urlencode($trackalbum);
			echo "<tr>";
			echo "<td><a href='search.php?artistidquery=$artistid'>$trackartist</a></td>";
			echo "<td><a href='search.php?trackquery=$utrackname'>$trackname</a></td>";
			echo "<td><a href='albumview.php?req=albumid&query=$albumid'>$trackalbum</a></td>";
			//echo "<td>" . $trackname . "</td> ";
			//echo "<td>" . $trackalbum . "</td> ";
			echo "</tr>\n";
		}
		} // nelly?
?>
</tbody>
</table>
</div>
</div>
<?php
echo totop($row_cnt);
echo pubpag($page, $noalbums, $heres, $offset);
?>

<?php
include("footer.php");
?>