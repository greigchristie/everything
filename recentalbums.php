<?php
include("functions.php");
include("connected.php");
include("includes/dbselect.php");

		$sqlc = "select count(id) from albums where album_owned = 1";
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
 <h2>All albums, recent additions first</h2>

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
<!-- <th>Name</th> -->
<th>Album</th>
 

</tr>
</thead>
 
<tbody>
<?php

//Just to see what comments look like!
	$trk = "tracks";
		$result = getRecentAlbumsPaginated($offset,$bottom);
		// $row_cnt = mysqli_num_rows($result);
		// echo "<h3>$row_cnt</h3>\n";
		while ($row = $result->fetch_assoc())
		{
		$albumartist = $row['album_artist_name'];
		$collection = $row['album_collection'];
		// $trackname = $row['tracktitle'];
		$trackalbum = $row['album_title'];
		$albumid = $row['id'];
		$artistid = $row['album_artist_id'];
			
		 $count = getTracksForAlbum($albumid);
		 // print_r($count);
		 $notracks = mysqli_num_rows($count);
				if ($notracks == 1) {
				$trk = "track";
				} else {
				$trk = "tracks"; 
				}
		
		$ualbumartist = urlencode($albumartist);
//		$utrackname = urlencode($trackname);
		$utrackalbum = urlencode($trackalbum);
			echo "<tr>";
			echo "<td><a href='artistview.php?artist=$artistid'>$albumartist</a></td>";
			// echo "<td><a href='refined.php?req=tracktitle&query=$utrackname'>$trackname</a></td>";
			echo "<td><a href='albumview.php?req=albumid&query=$albumid'>$trackalbum</a> ($notracks $trk) ($collection)</td>";
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