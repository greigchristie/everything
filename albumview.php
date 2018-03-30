<?php
include("functions.php");
include("connected.php");
include("includes/spotify.php");
$albumid = $_GET['query'];
$various = "";
//echo $getartist;

		$sql1 = "SELECT a.artist_name, b.album_title, b.album_owned FROM artists a, albums b";
		$sql1 = $sql1 . " where a.id = b.album_artist_id";
		$sql1 = $sql1 . " and b.id = \"$albumid\"";
		$sql1 = $sql1 . " and b.album_owned = 1";
//		echo "<h3>$sql1</h3>";
		$result1 = mysqli_query($con,$sql1);
		while ($row1 = mysqli_fetch_array($result1))
		{
			$albumartist = $row1['artist_name'];
			$albumtitle = $row1['album_title'];
			$albumowned = $row1['album_owned'];
			$ualbumtitle = urlencode($albumtitle);
			$ualbumartist = urlencode($albumartist);
		}

?>
<?php		
include("header.php");	
if ($albumowned == 0) { echo "<h2>Album Not Found</h2>";}	 else {
$spotifys = spotifyIdCover($albumtitle, $albumartist);
// print_r($spotifys);

$spotify = explode(' - ', $spotifys);
$spotifyuri = $spotify[0];
$coverimage = $spotify[1];

		?>

<div class="row"> <!-- row 1 -->
<div class="col-12">
<?php
	if ($spotifyuri != "") {
	 echo "<h2 class='alert-info'><em><a href='".$spotifyuri."'>".$albumtitle." by ". $albumartist."</a></em></strong></h2>"; 
	 echo "</div>";
	 echo "</div>";

	} else {
	 echo "<h2 class='alert-info'>".$albumtitle." by ". $albumartist."</h2>"; 
	 echo "</div>";
	 echo "</div>";
	}
	if ($coverimage != "") {
	echo "<p class='d-block d-sm-none text-center'><img src='$coverimage'></p>";
	}
	?>


<!-- </div>
</div> -->


<?php

//Just to see what comments look like!
		$sql = "SELECT a.artist_name, b.album_collection, c.track_title, c.track_artist_id, b.album_artist_id, a.id from artists a, albums b, tracks c";
		$sql = $sql . " where a.id = c.track_artist_id";
		$sql = $sql . " and b.id = album_id";
		$sql = $sql . " and b.id = \"$albumid\"";
		$sql = $sql . " and c.track_owned = 1";
		$sql = $sql . " and b.album_owned = 1";
		$sql = $sql . " order by c.track_order";
		//$sql = $sql . " LIMIT $offset offset $bottom";
		//$sql = $sql . " group by trackartist";
//		echo $sql;
		$result = mysqli_query($con,$sql);
		//$row_cnt = mysqli_num_rows($result);
		//echo "<h3>$row_cnt</h3>";
		echo "<div class='row'>"; //start row 2
//		echo "<div class='col-xs-1'>";
//		echo "</div>";
		echo "<div class='col-8'>";
		echo "<ol>";
		$row_cnt = mysqli_num_rows($result);
		while ($row = mysqli_fetch_array($result))
		{
		$track_artist_id = $row['track_artist_id'];
		$album_artist_id = $row['album_artist_id'];
		$trackartist = $row['artist_name'];
		$tracktitle = $row['track_title'];
		$collection = $row['album_collection'];
		$artistid = $row['id'];
		$utrackartist = urlencode($trackartist);
		$utracktitle = urlencode($tracktitle);

                $ualbumartist = urlencode($albumartist);
                if ($album_artist_id != $track_artist_id) { $various = "true"; } else { $various = "false"; }
		echo "<div class='row'><div class='col-12'><li>"; //row 3
		 if($various == "true") {
			echo "<a href='search.php?artistidquery=$artistid'><strong>$trackartist</strong></a> - ";
			} 
			echo "<a href='search.php?trackquery=$utracktitle'>$tracktitle</a> ";
			echo "<a href='json.php?artist=$utrackartist&track=$utracktitle'>";
			//if ($spotifyuri != "") {
//			echo "<img src='images/spotify.png'>";
			echo "<i class=\"fa fa-spotify\" style='font-size: 12pt;'></i>";
			//}
			echo "</a>";
		echo "</li></div></div>\n"; //end row 3
		}
		echo "</ul>";
		echo "</div>";
		echo "<div class='col-4 hidden-xs text-center'>";
		if ($coverimage != "") {
		echo "<img src='$coverimage' class='img-responsive'>";
		}
		if ($spotifyuri != "") {

	 echo "<iframe src=\"https://embed.spotify.com/?uri=$spotifyuri\" width=\"300\" height=\"380\" frameborder=\"0\" allowtransparency=\"true\"></iframe>";


		}
		echo "</div>";
		echo "</div>\n"; // end row 2
		echo "<a href='artistview.php?artist=$album_artist_id'>Click to see all albums by $albumartist</a>";
		echo "<p> From $collection collection</p>";
?>
	
<?php
echo totop($row_cnt);
		echo "<p><a href='albumedit.php?req=albumid&query=$albumid'>Edit</a></p>";
	} //end album_owned check
include("footer.php");
?>
