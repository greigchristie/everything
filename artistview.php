<?php
include("functions.php");
include("connected.php");
include("includes/spotify.php");
include("includes/dbselect.php");
$getartist = $_GET['artist'];

// retrieve artist details using artist ID
		$resultc = getArtistDetailsId($getartist);
		while ($row1 = mysqli_fetch_array($resultc))
		{
		$artist1 = $row1['artist_name'];
		$altartist = $row1['artist_alt_id'];
//		echo "$altartist<br>";
		}


if ($altartist != 0){
	$rez = getArtistDetailsId($altartist);
	while ($roz = mysqli_fetch_array($rez)){
		$alt_artist_name = $roz['artist_name'];
	} // else { $alt_artist_name = "1429xxx"; }
	}


// call spotify spi artist function
$spotifyArtistName = spotifyArtist($artist1);
$spotifyArtistSplit = explode(' - ', $spotifyArtistName);

$coverimage = $spotifyArtistSplit[0];
$artistSpotName = $spotifyArtistSplit[1];
$spotifyuri = $spotifyArtistSplit[2];

include("header.php");
?>

<div class="row">
<div class ="col-12 alert-info">
<?php
	if ($spotifyuri != "") {
	 echo "<h2><a href='".$spotifyuri."'>".ucwords($artist1)."</a></h2>"; 
	} else {
	 echo "<h2>". ucwords($artist1)."</h2>"; 
	}

	?>
</div>
</div>
<div class ="row">
<div class="col-12">
&nbsp;
</div>
</div>
<!-- <?php 		
		$dlibrary = "dlibrary";

?> -->
<div class ="row">
<div class="col-12">
Albums by Artist
</div>
</div>
<div class ="row">
<div class="col-8"><ol class="olalbums">
<?php
	if ($altartist != "0") { echo "<small>Other releases as: <a href='artistview.php?artist=$altartist'>$alt_artist_name</a></small><br>";}
		$collections = getAlbumCollectionForAlbumArtist($getartist);
		while ($line = mysqli_fetch_array($collections)) {
			$collection = $line['album_collection'];
			echo "From $collection";
			$result = getAlbumsByArtistIdCollection($getartist,$collection);
		$row_cnt = mysqli_num_rows($result);
		echo " - $row_cnt Albums<br>";
	if ($row_cnt != 0) { 
		while ($row = mysqli_fetch_array($result))
		{
		$albumtitle = $row['album_title'];
		$albumid = $row['id'];
			
		echo "<div class='row'><h3 class='col-12 lead'><li class='al-$collection'><a href='albumview.php?req=albumid&query=$albumid'>$albumtitle</a> ($collection) <i class=\"fa fa-plus-square\" style='font-size: 12pt;' onclick='showUser($albumid)' id='openList$albumid'></i><i class=\"fa fa-minus-square\" style='font-size: 12pt; display: none;' onclick='hideDiv($albumid)' id='closeList$albumid'></i></li></h3></div>\n";
			echo "<div class='row'><div class='col-12' id='trackCon$albumid'></div></div>\n";

		}
	} 	else {
	echo "<div class =\"row\">";
	echo "<div class=\"col-8\"><ol>";
	}
		} 
?>
</ol>

<?php

//Just to see what comments look like!
		$sql = "SELECT a.artist_name, b.album_collection, b.album_title, b.id";
		$sql = $sql . " from artists a, albums b";
		$sql = $sql . " where b.album_artist_id = a.id";
		$sql = $sql . " and a.id = \"$getartist\"";
		$sql = $sql . "and b.album_collection = \"cdsingle\"";

		//$sql = $sql . " LIMIT $offset offset $bottom";
		//$sql = $sql . " group by trackartist";
		//echo $sql;
		$result = mysqli_query($con,$sql);
		$row_cnt = mysqli_num_rows($result);
		?>

<div class ="row">
<div class="col-12">
&nbsp;
</div>
</div>

<div class ="row">
<div class="col-12">

</div>
</div>
<?php
	echo "<div class =\"row\">";
	echo "<div class=\"col-8\">";

?>

<?php
		$result = getAlbumsByTrackArtistNotAlbumArtist($getartist);
		$row_cnt = mysqli_num_rows($result);
		if ($row_cnt != 0) {
		?>

<div class ="row">
<div class="col-12">
<a href="search.php?variousquery=<?php echo urlencode($getartist); ?>">Albums featuring Artist</a> <small><?php echo "($row_cnt Albums)"; ?></small>:
</div>
</div>
<div class ="row">
<div class="col-8"><ol  class-"olstuff">
<?php
		while ($row = mysqli_fetch_array($result))
		{
		
		$albumtitle = $row['album_title'];
		$albumid = $row['id'];
		$collection = $row['album_collection'];
		//$trackname = $row['trackname'];
		//$trackalbum = $row['trackalbum'];
//		$ualbumartist = urlencode($albumartist);
		$ualbumtitle = urlencode($albumtitle);


			//echo "<td>$albumartist</td>";
			echo "<div class='row'><div class='col-12 lead'><li><a href='albumview.php?req=albumid&query=$albumid'>$albumtitle</a> ($collection) <i class=\"fa fa-plus-square\" style='font-size: 12pt;' onclick='showUser($albumid)' id='openList$albumid'></i><i class=\"fa fa-minus-square\" style='font-size: 12pt; display: none;' onclick='hideDiv($albumid)' id='closeList$albumid'></i></li></div></div>\n";
			
			echo "<div class='row'><div class='col-12' id='trackCon$albumid'></div></div>\n";
			/*echo "<td><a href='refined.php?req=trackartist&query=$utrackartist'>$trackartist</a></td>";
			//echo "<td><a href='refined.php?req=trackname&query=$utrackname'>$trackname</a></td>";
			//echo "<td><a href='refined.php?req=trackalbum&query=$utrackalbum'>$trackalbum</a></td>";
			//echo "<td>" . $trackname . "</td> ";
			//echo "<td>" . $trackalbum . "</td> ";*/

		}
	} // check if no items returned 
	else {
	echo "<div class =\"row\">";
	echo "<div class=\"col-8\"><ol>";
	}
	// nelly?	} 
?>
</ol>
</div>
</div>
</div>
</div>
</div>
<div class="col-4 text-center">
<?php
	if ($coverimage != "") {
	echo "<img src='$coverimage' class='img-fluid'>";
	echo "<br><em>$artistSpotName</e,>";
	} else { echo "<h2>Need to implement new Spotify auth</h2>";}

?>
</div>
</div> <!-- close row for the split column -->
<P><a href="artistedit.php?artist=<?php echo $getartist; ?>">Edit</a></p>
<?php
include("footer.php");
?>
