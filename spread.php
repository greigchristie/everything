<?php
include("functions.php");
include("connected.php");
include("header.php");
$collection = $_POST['collection'];
$collection - mysqli_real_escape_string($con, $collection);
$limit = $_POST['limit'];
$limit = mysqli_real_escape_string($con, $limit);
$f = fopen("php://output", "w");
$sql = "SELECT * from albums";
$sql = $sql . " where album_collection = '$collection'";
$sql = $sql . " order by id desc";
$sql = $sql . " limit $limit";

 echo $sql;
		$result = mysqli_query($con,$sql);
				 $row_cnt = mysqli_num_rows($result);
				 echo "<h3>$row_cnt</h3>";
		echo "<pre>";
		while ($row = mysqli_fetch_array($result))
		{
		$aid = $row['id'];
		$album_artist = $row['album_artist_name'];
		$album_title = $row['album_title'];
		$sort_name = $album_artist;
		
		echo "$aid\t$album_artist\t$albumtitle\t$sort_name\n";
		
		}
		echo "</pre>";
include("footer.php");
?>