<?php
include("functions.php");
include("connected.php");
include("includes/spotify.php");
$getartist = $_GET['artist'];
$coverimage = "";

include("header.php");
?>


<?php

//Just to see what comments look like!

		?>
<div class="row">
<div class ="col-12 alert-info">
<?php

	 $sql1 = "select artist_name, artist_alt_id from artists where id = $getartist";
	 $resultz = mysqli_query($con,$sql1);
	 $oneline = mysqli_fetch_assoc($resultz);
	 echo "<h2>".$oneline['artist_name']."</h2>";
	$artistalt = $oneline['artist_alt_id'];	
	?>
</div>
</div>
<div class ="row">
<div class="col-12">
&nbsp;
</div>
</div>

<div class ="row">
<div class="col-12">
Albums by Artist <?php 			if ($artistalt != "") {
			$swl = "select artist_name from artists where id = $artistalt";
			$burt = mysqli_query($con,$swl);
			$twoline = mysqli_fetch_assoc($burt);
			echo "<a href='artistview.php?artist=$artistalt'>Other releases as ".$twoline['artist_name']."</a>";
			
			}?>
</div>
</div>
<div class ="row">
<div class="col-12">
<a href="refined.php?req=albumartist&query=<?php echo urlencode($getartist); ?>">Artist Album Tracks</a>
</div>
<div class="col-8"><ol class="olalbums">
<?php
		$sql = "SELECT a.artist_name, a.artist_alt_id, b.album_collection, b.album_title, b.id, b.album_cover";
		$sql = $sql . " from artists a, albums b";
		$sql = $sql . " where b.album_artist_id = a.id";
		$sql = $sql . " and a.id = \"$getartist\"";
		$sql = $sql . " and b.album_collection <> \"cdsingle\"";
		$sql = $sql . " and b.album_owned = 1";


		//$sql = $sql . " LIMIT $offset offset $bottom";
		//$sql = $sql . " group by trackartist";
//		 echo $sql;
		$result = mysqli_query($con,$sql);
		$row_cnt = mysqli_num_rows($result);
		while ($row = mysqli_fetch_array($result))
		{
		$albumartist = $row['artist_name'];
		$artistalt = $row['artist_alt_id'];
		$albumtitle = $row['album_title'];
		$albumid = $row['id'];
		$trackartist = $row['artist_name'];
		$collection = $row['album_collection'];
		if ($row['album_cover'] != "") {
		$coverimage = $row['album_cover'];
		}
		//$trackname = $row['trackname'];
		//$trackalbum = $row['trackalbum'];
		$ualbumartist = urlencode($albumartist);
		$ualbumtitle = urlencode($albumtitle);


			//echo "<td>$albumartist</td>";

			echo "<div class='row'><h3 class='col-12 lead'><li class='al-$collection'><a href='albumview.php?req=albumid&query=$albumid'>$albumtitle</a> ($collection) <i class=\"fa fa-plus-square\" style='font-size: 12pt;' onclick='showUser($albumid)' id='openList$albumid'></i><i class=\"fa fa-minus-square\" style='font-size: 12pt; display: none;' onclick='hideDiv($albumid)' id='closeList$albumid'></i></li></h3></div>\n";
			echo "<div class='row'><div class='col-12' id='trackCon$albumid'></div></div>\n";

			/*echo "<td><a href='refined.php?req=trackartist&query=$utrackartist'>$trackartist</a></td>";
			//echo "<td><a href='refined.php?req=trackname&query=$utrackname'>$trackname</a></td>";
			//echo "<td><a href='refined.php?req=trackalbum&query=$utrackalbum'>$trackalbum</a></td>";
			//echo "<td>" . $trackname . "</td> ";
			//echo "<td>" . $trackalbum . "</td> ";*/

		}
	
	// nelly?	} 
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
<?php 		if ($row_cnt != 0) { ?>
<div class ="row">
<div class="col-12">
CD Singles by Artist <small><?php echo "($row_cnt CD Singles)"; ?></small>:
</div>
</div>
<div class ="row">
<div class="col-8"><ol class-"olsingles">
<?php
		while ($row = mysqli_fetch_array($result))
		{
		$albumartist = $row['artist_name'];
		$albumtitle = $row['album_title'];
		$albumid = $row['id'];
		$trackartist = $row['artist_name'];
		$collection = $row['album_collection'];
		//$trackname = $row['trackname'];
		//$trackalbum = $row['trackalbum'];
		$ualbumartist = urlencode($albumartist);
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
	echo "</ol>";	
	} 	else {
	echo "<div class =\"row\">";
	echo "<div class=\"col-8\">";
	}
	// nelly?	} 
?>

<?php

//Just to see what comments look like!
		$sql = "SELECT b.album_title, b.id, b.album_collection from albums b, tracks c";
		$sql = $sql . " where b.id = c.album_id";
		$sql = $sql . " and (c.track_artist_id = \"$getartist\"";
		$sql = $sql . " and b.album_artist_id <> \"$getartist\")";
		$sql = $sql . " group by b.id, b.album_title, b.album_collection";
		$sql = $sql . " order by b.id";
		//$sql = $sql . " LIMIT $offset offset $bottom";
		//$sql = $sql . " group by trackartist";
		// echo $sql;
		$result = mysqli_query($con,$sql);
		$row_cnt = mysqli_num_rows($result);
		if ($row_cnt != 0) {
		?>

<div class ="row">
<div class="col-12">
<a href="refined.php?req=variousartist&query=<?php echo urlencode($getartist); ?>">Albums featuring Artist</a> <small><?php echo "($row_cnt Albums)"; ?></small>:
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
	if ($coverimage == "") {

// call spotify spi artist function
$spotifyArtistName = spotifyArtist($albumartist);
$spotifyArtistSplit = explode(' - ', $spotifyArtistName);

$coverimage = $spotifyArtistSplit[0];
$artistSpotName = $spotifyArtistSplit[1];
$spotifyuri = $spotifyArtistSplit[2];
	echo "<img src='$coverimage' class='img-fluid'>";
	echo "<br><em>$artistSpotName</em>";
	} else { 
	echo "<img src='$coverimage' class='img-fluid'>";
	echo "<br><em>$artistname</em>";
	}

?>
</div>
</div> <!-- close row for the split column -->
<P><a href="artistedit.php?artist=<?php echo $getartist; ?>">Edit</a></p>
<?php
include("footer.php");
?>
