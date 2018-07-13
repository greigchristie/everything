<?php
include("connected.php");
$albumid = $_GET['q'];

//$albumid = "2240";
		$sql = "SELECT artist_name, track_title, track_order, track_artist_id, artists.id, albums.id as albumsid, album_artist_id from artists, albums, tracks";
		$sql = $sql . " where artists.id = tracks.track_artist_id ";
		$sql = $sql . " and tracks.album_id =  albums.id";
		$sql = $sql . " and album_id = '$albumid'";
		$sql = $sql ." and tracks.track_owned = 1 order by track_order asc";
//		echo $sql;
		$result = mysqli_query($con,$sql);
		// echo "<ol>";
		while ($row = mysqli_fetch_array($result))
		{
		$track_artist_id = $row['track_artist_id'];
		$album_artist_id = $row['album_artist_id'];
		$artist_name = $row['artist_name'];
		$track_title = $row['track_title'];
		$track_order = $row['track_order'];
		if ($album_artist_id != $track_artist_id){
			echo "$track_order. <strong>$artist_name</strong> - $track_title<br>\n";

		} else {
		echo "$track_order. $track_title<br>\n";
	}
		}
		 echo "<br>\n";
//		mysqli_close($con);
?>