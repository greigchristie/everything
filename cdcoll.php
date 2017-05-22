<?php
include("connected.php");
include("functions.php");
header('Content-Type:text/html; charset=UTF-8');
include("header.php");
?>


<h2>My CD Collection</h2>
<table class="table table-striped">
<thead>
<tr>
<th>Artist</th>
<th>Album</th>
 
</tr>
</thead>
 
<tbody>
<?php
//Just to see what comments look like!
		$sql = "SELECT a.artist_name, b.album_title";
		$sql = $sql . " from artists a, albums b";
		$sql = $sql . " where a.id = b.artist_id";
		$sql = $sql . " and b.album_collection = 'dlibrary'";
		$sql = $sql . " order by a.artist_sort_name, b.album_title";
		$result = mysqli_query($con,$sql);
				$row_cnt = mysqli_num_rows($result);
				echo "<h3>$row_cnt</h3>";
		while ($row = mysqli_fetch_array($result))
		{
		//$trackartist = $row['trackartist'];
		//$trackname = $row['trackname'];
		$trackalbum = $row['album_title'];
		//$albumid = $row['albumid'];
		$albumartist = $row['artist_name'];
		//$utrackartist = urlencode($trackartist);
		//$utrackname = urlencode($trackname);
		$utrackalbum = urlencode($trackalbum);
			echo "<tr>";
			//echo "<td><a href='refined.php?req=trackartist&query=$utrackartist'>$trackartist</a></td>";
			//echo "<td><a href='refined.php?req=trackname&query=$utrackname'>$trackname</a></td>";
			echo "<td>$albumartist</td>";
			echo "<td>$trackalbum</td>";
			//echo "<td>" . $trackname . "</td> ";
			//echo "<td>" . $trackalbum . "</td> ";
			echo "</tr>\n";
		}

?>
</tbody>
</table>
<?php
include("footer.php");
?>