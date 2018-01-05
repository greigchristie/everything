<?php
include("functions.php");
include("connected.php");
include("spauth.php");
$getartist = $_GET['artist'];
$sqla = "select artist_name from artists where id = $getartist";
		$resultc = mysqli_query($con,$sqla);
				while ($row = mysqli_fetch_row($resultc))
						{
		$artist1 = $row[0];
		}
$sgetartist = mysqli_real_escape_string($con, $artist1);
$uartist = urlencode($artist1);
//echo $getartist;



			$url ="https://api.spotify.com/v1/search?q=$uartist&type=artist&market=gb&limit=5";
			$headers = array("Authorization: Bearer " . $_SESSION['SP_TOKEN']);

			       // echo "service url<pre>";
			       // echo $url."<br />";
			       // echo "</pre>";
			//  Initiate curl
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// Will return the response, if false it print the response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'everything/2.0 +http://every-thing.co.uk');
			// Set the url
			curl_setopt($ch, CURLOPT_URL,$url);
			// Execute
			$result=curl_exec($ch);
			// Closing
			curl_close($ch);
			// echo "<pre>";
			// print_r($result);
			// echo "</pre>";
			$results = json_decode($result);
			
		$spotifyuri = $results->artists->items;
		$spotifyuri = "";
		if (count($spotifyuri) > 0) {
		$spotifyuri = $results->artists->items[0]->uri;
		} else {
		$spotifyuri = "";
		}
		$coverimage = "";
		if ($spotifyuri != "") {
		$coverimage = $results->artists->items[0]->images[1]->url;
		}

include("header.php");
?>


<?php

//Just to see what comments look like!
		$sql = "SELECT a.artist_name, b.album_collection, b.album_title, b.id";
		$sql = $sql . " from artists a, albums b";
		$sql = $sql . " where b.artist_id = a.id";
		$sql = $sql . " and a.id = \"$getartist\"";
		$sql = $sql . " and b.album_collection <> \"cdsingle\"";
		$sql = $sql . " and b.album_owned = 1";


		//$sql = $sql . " LIMIT $offset offset $bottom";
		//$sql = $sql . " group by trackartist";
//		 echo $sql;
		$result = mysqli_query($con,$sql);
		$row_cnt = mysqli_num_rows($result);
		?>
<div class="row">
<div class ="col-xs-12 alert-info">
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
<div class="col-xs-12">
&nbsp;
</div>
</div>
<?php 		if ($row_cnt != 0) { ?>
<div class ="row">
<div class="col-xs-12">
Albums by Artist <small class="olalbums">(<strong><?php echo "$row_cnt Albums"; ?></strong></small><small>)</small>
</div>
</div>
<div class ="row">
<div class="col-xs-8"><ol class="olalbums">
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
			
			echo "<div class='row'><h3 class='col-xs-12 lead'><li class='al-$collection'><a href='albumview.php?req=albumid&query=$albumid'>$albumtitle</a> ($collection) <i class=\"fa fa-plus-square\" style='font-size: 12pt;' onclick='showUser($albumid)' id='openList$albumid'></i><i class=\"fa fa-minus-square\" style='font-size: 12pt; display: none;' onclick='hideDiv($albumid)' id='closeList$albumid'></i></li></h3></div>\n";
			echo "<div class='row'><div class='col-xs-12' id='trackCon$albumid'></div></div>\n";

			/*echo "<td><a href='refined.php?req=trackartist&query=$utrackartist'>$trackartist</a></td>";
			//echo "<td><a href='refined.php?req=trackname&query=$utrackname'>$trackname</a></td>";
			//echo "<td><a href='refined.php?req=trackalbum&query=$utrackalbum'>$trackalbum</a></td>";
			//echo "<td>" . $trackname . "</td> ";
			//echo "<td>" . $trackalbum . "</td> ";*/

		}
	} 	else {
	echo "<div class =\"row\">";
	echo "<div class=\"col-xs-8\"><ol>";
	}
	// nelly?	} 
?>
</ol>

<?php

//Just to see what comments look like!
		$sql = "SELECT a.artist_name, b.album_collection, b.album_title, b.id";
		$sql = $sql . " from artists a, albums b";
		$sql = $sql . " where b.artist_id = a.id";
		$sql = $sql . " and a.id = \"$getartist\"";
		$sql = $sql . "and b.album_collection = \"cdsingle\"";

		//$sql = $sql . " LIMIT $offset offset $bottom";
		//$sql = $sql . " group by trackartist";
		//echo $sql;
		$result = mysqli_query($con,$sql);
		$row_cnt = mysqli_num_rows($result);
		?>

<div class ="row">
<div class="col-xs-12">
&nbsp;
</div>
</div>
<?php 		if ($row_cnt != 0) { ?>
<div class ="row">
<div class="col-xs-12">
CD Singles by Artist <small><?php echo "($row_cnt CD Singles)"; ?></small>:
</div>
</div>
<div class ="row">
<div class="col-xs-8"><ol class-"olsingles">
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
			echo "<div class='row'><div class='col-xs-12 lead'><li><a href='albumview.php?req=albumid&query=$albumid'>$albumtitle</a> ($collection) <i class=\"fa fa-plus-square\" style='font-size: 12pt;' onclick='showUser($albumid)' id='openList$albumid'></i><i class=\"fa fa-minus-square\" style='font-size: 12pt; display: none;' onclick='hideDiv($albumid)' id='closeList$albumid'></i></li></div></div>\n";
			echo "<div class='row'><div class='col-xs-12' id='trackCon$albumid'></div></div>\n";
			/*echo "<td><a href='refined.php?req=trackartist&query=$utrackartist'>$trackartist</a></td>";
			//echo "<td><a href='refined.php?req=trackname&query=$utrackname'>$trackname</a></td>";
			//echo "<td><a href='refined.php?req=trackalbum&query=$utrackalbum'>$trackalbum</a></td>";
			//echo "<td>" . $trackname . "</td> ";
			//echo "<td>" . $trackalbum . "</td> ";*/

		}
	echo "</ol>";	
	} 	else {
	echo "<div class =\"row\">";
	echo "<div class=\"col-xs-8\">";
	}
	// nelly?	} 
?>

<?php

//Just to see what comments look like!
		$sql = "SELECT b.album_title, b.id, b.album_collection from albums b, tracks c";
		$sql = $sql . " where b.id = c.album_id";
		$sql = $sql . " and (c.track_artist_id = \"$getartist\"";
		$sql = $sql . " and c.album_artist_id <> \"$getartist\")";
		$sql = $sql . " group by b.id, b.album_title, b.album_collection";
		$sql = $sql . " order by b.id";
		//$sql = $sql . " LIMIT $offset offset $bottom";
		//$sql = $sql . " group by trackartist";
//		echo $sql;
		$result = mysqli_query($con,$sql);
		$row_cnt = mysqli_num_rows($result);
		if ($row_cnt != 0) {
		?>

<div class ="row">
<div class="col-xs-12">
<a href="refined.php?req=variousartist&query=<?php echo urlencode($getartist); ?>">Albums featuring Artist</a> <small><?php echo "($row_cnt Albums)"; ?></small>:
</div>
</div>
<div class ="row">
<div class="col-xs-8"><ol  class-"olstuff">
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
			echo "<div class='row'><div class='col-xs-12 lead'><li><a href='albumview.php?req=albumid&query=$albumid'>$albumtitle</a> ($collection) <i class=\"fa fa-plus-square\" style='font-size: 12pt;' onclick='showUser($albumid)' id='openList$albumid'></i><i class=\"fa fa-minus-square\" style='font-size: 12pt; display: none;' onclick='hideDiv($albumid)' id='closeList$albumid'></i></li></div></div>\n";
			
			echo "<div class='row'><div class='col-xs-12' id='trackCon$albumid'></div></div>\n";
			/*echo "<td><a href='refined.php?req=trackartist&query=$utrackartist'>$trackartist</a></td>";
			//echo "<td><a href='refined.php?req=trackname&query=$utrackname'>$trackname</a></td>";
			//echo "<td><a href='refined.php?req=trackalbum&query=$utrackalbum'>$trackalbum</a></td>";
			//echo "<td>" . $trackname . "</td> ";
			//echo "<td>" . $trackalbum . "</td> ";*/

		}
	} // check if no items returned 
	else {
	echo "<div class =\"row\">";
	echo "<div class=\"col-xs-8\"><ol>";
	}
	// nelly?	} 
?>
</ol>
</div>
</div>
</div>
</div>
</div>
<div class="col-xs-4 text-center">
<?php
	if ($coverimage != "") {
	echo "<img src='$coverimage' class='img-responsive'>";
	} else { echo "<h2>Need to implement new Spotify auth</h2>";}

?>
</div>
</div> <!-- close row for the split column -->

<?php
include("footer.php");
?>
