<?php
include("functions.php");
include("connected.php");
include("header.php");
$collection = $_POST['collection'];
$collection - mysqli_real_escape_string($con, $collection);
$limit = $_POST['limit'];
$limit = mysqli_real_escape_string($con, $limit);
$f = fopen("php://output", "w");
$sql = "SELECT b.id, b.album_artist_name, b.album_title, a.artist_sort_name from artists a, albums b";
$sql = $sql . " where a.id = b.album_artist_id";
$sql = $sql . " and b.album_collection = '$collection'";
$sql = $sql . " order by b.id desc";
$sql = $sql . " limit $limit";

// echo $sql;
		$result = mysqli_query($con,$sql);
				 $row_cnt = mysqli_num_rows($result);
				 echo "<h3>$row_cnt</h3>";
		echo "<table class='table'>\n";
		echo "<thead>\n";
		echo "<tr>\n";
		echo "<th>ID</th>\n";
		echo "<th>Artist</th>\n";
		echo "<th>Album</th>\n";
		echo "<th>Ripped</th>\n";
		echo "<th>Sort Name</th>\n";
		echo "</tr>\n";
		echo "</thead>\n";
		echo "<tbody>\n";
		while ($row = mysqli_fetch_array($result))
		{
//		print_r($row);
		$aid = $row['id'];
		$album_artist = $row['album_artist_name'];
		$album_title = $row['album_title'];
		$sort_name = $row['artist_sort_name'];
		
		echo "<tr><td>$aid</td><td>$album_artist</td><td>$album_title</td><td></td><td>$sort_name</td></tr>";

		
		}
		echo "</tbody>";
		echo "</table>";
include("footer.php");
?>