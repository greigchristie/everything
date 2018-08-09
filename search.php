<?php
include("functions.php");
include("connected.php");
include("includes/dbselect.php");
$requery = "";
$query = "nut";
$querytype = "requery";
$sort = "track_sort_title";
if (isset($_GET['sort'])){
$sort = $_GET['sort'];
}
	if (isset($_GET['requery'])) {
		$requery = $_GET['requery'];
		$querytype = "requery";
		}
	if (isset($_GET['albumartistquery'])){
		$requery = $_GET['albumartistquery'];
		$query = "nut";
		$querytype = "albumartistquery";
	}
	if (isset($_GET['artistquery'])){
		$requery = $_GET['artistquery'];
		$query = "artist_name";
		$querytype = "artistquery";
	}	
	if (isset($_GET['artistidquery'])){
		$requery = $_GET['artistidquery'];
		$query = "a.id";
		$querytype = "artistidquery";
	}	
	if (isset($_GET['albumquery'])){
		$requery = $_GET['albumquery'];
		$query = "album_title";
		$querytype = "albumquery";
	}
	if (isset($_GET['albumidquery'])){
		$requery = $_GET['albumidquery'];
		$query = "b.id";
		$querytype = "albumidquery";
	}
	if (isset($_GET['trackquery'])){
		$requery = $_GET['trackquery'];
		$query = "track_title";
		$querytype = "trackquery";
	}	
	if (isset($_GET['collquery'])){
		$requery = $_GET['collquery'];
		$query = "album_collection";
		$querytype = "collquery";
	}
		if (isset($_GET['variousquery'])){
		$requery = $_GET['variousquery'];
		$query = "album_sort_title";
		$querytype = "variousquery";
	}
	
include("header.php");
?>

 <h2>Search results</h2>
 <div class="row">
 <div class="col-xs-12 col-md-10 col-lg-8">
<table class="table table-striped">

<thead>
<tr>

		<?php if ($querytype == "collquery" || $querytype == "albumartistquery" ) { ?>
<th <?php if ($sort == "album_artist_name") {echo "class='text-danger'";} ?>>Album Artist<a href="search.php?<?php echo $querytype; ?>=<?php echo $requery?>&sort=album_artist_name"><span class="caret"></span></a></th>
<th  <?php if ($sort == "album_title") {echo "class='text-danger'";} ?> >Album<a href="search.php?<?php echo $querytype; ?>=<?php echo $requery?>&sort=album_title" ><span class="caret"></span></a></th>

		<?php } else { ?>	

 <th <?php if ($sort == "album_artist_name") {echo "class='text-danger'";} ?>>Album Artist<a href="search.php?<?php echo $querytype; ?>=<?php echo $requery?>&sort=album_artist_name"><span class="caret"></span></a></th>
 <th <?php if ($sort == "artist_name") {echo "class='text-danger'";} ?>>Track Artist<a href="search.php?<?php echo $querytype; ?>=<?php echo $requery?>&sort=artist_name"><span class="caret"></span></a></th>

<th <?php if ($sort == "track_title") {echo "class='text-danger'";} ?>>Title<a href="search.php?<?php echo $querytype; ?>=<?php echo $requery?>&sort=track_title"><span class="caret"></span></a></th>
 
<th  <?php if ($sort == "album_title") {echo "class='text-danger'";} ?> >Album<a href="search.php?<?php echo $querytype; ?>=<?php echo $requery?>&sort=album_title" ><span class="caret"></span></a></th>
<?php } ?>


 
</tr>
</thead>
 
<tbody>
<?php
	//echo "<pre>";
	//print_r($_GET);
	//echo "</pre>";

		// Call search query appropriate to search type (prepared statements in an include)
		
		if ($querytype == "requery") {
//		echo "keyword $requery";
		$result = searchKeyword($requery);
		}
		if ($querytype == "albumartistquery") {
		$result = searchAlbumArtist($requery);
		}
		if ($querytype == "artistquery") {
		$result = searchTrackArtist($requery);
		}
		if ($querytype == "artistidquery") {
		$result = searchArtistId($requery);
		}		
		if ($querytype == "albumidquery") {
		$result = searchAlbumId($requery);
		}
		if ($querytype == "albumquery") {
		$result = searchAlbumTitle($requery);
		}
		if ($querytype == "trackquery") {
		$result = searchTrackTitle($requery);
		}
		if ($querytype == "collquery") {
		$result = searchCollection($requery);
		}
		if ($querytype == "variousquery") {
		$result = getTracksNotAlbumArtistId($requery);
		}

		$row_cnt = mysqli_num_rows($result);
		echo "<h3>$row_cnt</h3>\n";
		while ($row = $result->fetch_assoc())
		{
			if (isset($_GET['albumartistquery'])) {
			$albumartist = $row['album_artist_name'];
			$trackalbum = $row['album_title'];
			$artistid = $row['album_artist_id'];
			$albumid = $row['album_id'];
			$albumcollection = $row['album_collection'];
			echo "<tr>";
			echo "<td><a href='artistview.php?artist=$artistid'>$albumartist</a></td>";
			echo "<td><a href='search.php?albumidquery=$albumid'>$trackalbum</a> ($albumcollection)</td>";
			echo "<td></td>";
			//echo "<td>" . $trackalbum . "</td> ";
			echo "</tr>\n";
			//echo "<td>" . $trackname . "</td> ";
			//echo "<td>" . $trackalbum . "</td> ";
			}
			elseif (isset($_GET['collquery'])) {
			$albumartist = $row['album_artist_name'];
			$trackalbum = $row['album_title'];
			$artistid = $row['album_artist_id'];
			$albumid = $row['album_id'];
			$albumcollection = $row['album_collection'];
			echo "<tr>";
			echo "<td><a href='artistview.php?artist=$artistid'>$albumartist</a></td>";
			echo "<td><a href='search.php?albumidquery=$albumid'>$trackalbum</a> ($albumcollection)</td>";
			echo "<td></td>";
			//echo "<td>" . $trackalbum . "</td> ";
			echo "</tr>\n";
			
			} else {
		$trackartist = $row['artist_name'];
		$albumartist = $row['album_artist_name'];
		$trackname = $row['track_title'];
		$trackalbum = $row['album_title'];
		$albumid = $row['album_id'];
		$albumartistid = $row['album_artist_id'];
		$artistid = $row['artist_id'];
		$albumcollection = $row['album_collection'];
		$utrackname = urlencode($trackname);			
			echo "<tr>";
			echo "<td><a href='artistview.php?artist=$albumartistid'>$albumartist</a></td>";
			if ($artistid != $albumartistid){ 
				echo "<td><a href='artistview.php?artist=$artistid'>$trackartist</a></td>";
		} else {
			echo "<td><a href='search.php?artistidquery=$artistid'>$trackartist</a></td>";
		}
			echo "<td><a href='search.php?trackquery=$utrackname'>$trackname</a></td>";
			if ($querytype == "albumquery") {
				echo "<td><a href='albumview.php?albumid&query=$albumid'>$trackalbum</a> (".$row['album_collection'].")</td>";
			} else {
				echo "<td><a href='albumview.php?albumid&query=$albumid'>$trackalbum</a> (".$row['album_collection'].")</td>";
			}
			echo "</tr>\n";
			}
		}
		
?>
</tbody>
</table>
</div>
</div>
<?php
echo totop($row_cnt);
include("footer.php");
?>