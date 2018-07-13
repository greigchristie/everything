<?php
include("functions.php");
include("connected.php");
$requery = "";
$query = "nut";
$querytype = "requery";
$sort = "track_title";
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
	$sql = "SELECT a.artist_name, a.id as artist_id, b.album_title, c.track_title, b.id as album_id, b.album_collection, b.album_artist_name, b.album_artist_id";
	if ($querytype == "requery") {
	$reqplus = str_replace(' ',' >',$requery);
	$sql = $sql . ", match(artist_name) against('>$reqplus') as artist_key_rel,";
	$sql = $sql . "match(artist_name) against('\"$requery\"') as artist_rel,";
	$sql = $sql . "match(album_title) against('\"$requery\"') as album_rel,";
	$sql = $sql . "match(album_title) against('>$reqplus') as album_key_rel,";
	$sql = $sql . "match(track_title) against('\"$requery\"') as track_exact_rel, ";
	$sql = $sql . "match(track_title) against('>$reqplus') as track_key_rel"; 
	}
	$sql = $sql . " FROM artists a, albums b, tracks c";
	$sql = $sql . " where a.id = c.track_artist_id";
	$sql = $sql . " and b.id = c.album_id";
	$sql = $sql . " and b.album_owned = 1 ";
			
	if ($querytype == "requery") {
		
		//$requery = mysqli_real_escape_string($con, $requery);
		
		
//		$sql = $sql . " and (c.track_title LIKE '%".$requery."%'";
//		$sql = $sql . " OR a.artist_name LIKE '%".$requery."%'";
//		$sql = $sql . " OR b.album_title LIKE '%".$requery."%')";
			$sql = $sql . "and (";
			$sql = $sql . "MATCH( artist_name ) AGAINST ('+\"$requery\"' IN BOOLEAN MODE)";
			$sql = $sql . " or MATCH( artist_name ) AGAINST ('>$reqplus' IN BOOLEAN MODE)";
			$sql = $sql . " or MATCH( album_title ) AGAINST ('+\"$requery\"' IN BOOLEAN MODE)";
			$sql = $sql . " or MATCH( album_title ) AGAINST ('>$reqplus' IN BOOLEAN MODE)";
			$sql = $sql . " or MATCH( track_title ) AGAINST ('+\"$requery\"' IN BOOLEAN MODE)";
			$sql = $sql . " or MATCH( track_title ) AGAINST ('>$reqplus' IN BOOLEAN MODE)";
			$sql = $sql . ")";
		 $sql = $sql . "order by artist_rel desc, album_rel desc, track_exact_rel desc, artist_key_rel desc, album_key_rel desc, track_key_rel desc";
	}  elseif ($querytype == "albumartistquery") {
		$requery = mysqli_real_escape_string($con, $requery);
		$sql = "select a.artist_name, a.id as artist_id, b.id as album_id, b.album_title, b.album_collection from artists a, albums b";
		$sql = $sql . " where a.id = b.album_artist_id";
		$sql = $sql . " and a.artist_name LIKE \"%".$requery."%\"";
		$sql = $sql . " and b.album_owned = 1";
//			$sql = $sql . " group by album_id";
		$sql = $sql . " ORDER BY $sort ASC";
		// echo $sql;
	} elseif ($querytype == "collquery") {
		$requery = mysqli_real_escape_string($con, $requery);
		$sql = "select a.artist_name, a.id as artist_id, b.id as album_id, b.album_title, b.album_collection from artists a, albums b";
		$sql = $sql . " where a.id = b.album_artist_id";
		$sql = $sql . " and $query = '$requery'";
		$sql = $sql . " and b.album_owned = 1 ";
//			$sql = $sql . " group by album_id";
		$sql = $sql . " ORDER BY $sort ASC";
		// echo $sql;
	} elseif ($querytype == "albumidquery" || $querytype == "artistidquery"){
		$sql = $sql . " and $query = '$requery' ";
		// echo $sql;
	}	elseif ($query != "nut") {
		$requery = mysqli_real_escape_string($con, $requery);
		$sql = $sql . " and $query LIKE \"%".$requery."%\"";
			if ($query == "album_collection") {
			$sql = $sql . " group by album_id";
			// echo $sql;
			}
		$sql = $sql . " ORDER BY $sort ASC";
	} 

	if ($requery == "") {
		$sql = $sql . " LIMIT 100";
		//echo $sql;
	}
		 echo $sql."<br>";
		$result = mysqli_query($con,$sql);
		$row_cnt = mysqli_num_rows($result);
		echo "<h3>$row_cnt</h3>\n";

		while ($row = mysqli_fetch_array($result))
		{


			if (isset($_GET['albumartistquery'])) {
			$albumartist = $row['artist_name'];
			$trackalbum = $row['album_title'];
			$artistid = $row['artist_id'];
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
			$albumartist = $row['artist_name'];
			$trackalbum = $row['album_title'];
			$artistid = $row['artist_id'];
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