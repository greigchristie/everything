<?php
include("functions.php");
include("connected.php");

$sort = "trackartist, albumtitle, collection";

$req = $_GET['req'];
$query = $_GET['query'];
$req = mysqli_real_escape_string($con, $req);
$query = mysqli_real_escape_string($con, $query);
$va = "";
if (isset($_GET['sort'])){
$sort = $_GET['sort'];
}
include("header.php");
//$listid = $_SESSION['currentlist'];
?>
 <div class="row">
 <div class="col-xs-12 col-md-10 col-lg-8">
<h2>Matches</h2>
<table class="table table-striped">
<thead>
<tr>
<th <?php if ($sort == "albumartist") {echo "class='text-danger'";} ?>>Album Artist <a href="refined.php?req=<?php echo $req?>&query=<?php echo $query?>&sort=albumartist" ><span class="caret"></span></a></th>

<th <?php if ($sort == "trackartist") {echo "class='text-danger'";} ?>>Track Artist<a href="refined.php?req=<?php echo $req?>&query=<?php echo $query?>&sort=trackartist"><span class="caret"></span></a></th>
 
<th <?php if ($sort == "tracktitle") {echo "class='text-danger'";} ?>>Title<a href="refined.php?req=<?php echo $req?>&query=<?php echo $query?>&sort=tracktitle"><span class="caret"></span></a></th>
 
<th  <?php if ($sort == "albumtitle") {echo "class='text-danger'";} ?> >Album<a href="refined.php?req=<?php echo $req?>&query=<?php echo $query?>&sort=albumtitle" ><span class="caret"></span></a></th>
<?php if (isset($_SESSION['currentlist'])){ ?>
<th>Actions</th>
<?php } ?>
</tr>
</thead>
 
<tbody>
<?php
//Just to see what comments look like!
	//echo "<pre>";
	//print_r($_GET);
	//echo "</pre>";

// $heye = "hoi";

if ($req == "albumtitle") {
 $req = "b.id";
}
if ($req == "trackartist") {
 $req = "c.track_artist_id";
}
if ($req == "variousartist"){
	$req = "c.track_artist_id";
	$va = "variousartist";
}

		$sql = "SELECT a.artist_name, a.id as aid, b.album_title, c.track_title, b.id, b.album_collection, b.album_artist_name";

		$sql = $sql . " from artists a, albums b, tracks c";
		$sql = $sql . " where a.id = c.track_artist_id";
		$sql = $sql . " and b.id = c.album_id";
		$sql = $sql . " and $req = $query";
//		$sql = $sql . " ORDER BY $sort";
//		 echo $sql;
		$result = mysqli_query($con,$sql);
		$row_cnt = mysqli_num_rows($result);
		echo "<h3>$row_cnt</h3>";		
		while ($row = mysqli_fetch_array($result))
		{
		$albumartist = $row['artist_name'];
		$albumid = $row['id'];
		$artistid = $row['aid'];
		$aaid = $row['album_artist_id'];
		$aaname = $row['album_artist_name'];
		$trackartist = $row['artist_name'];
		$trackname = $row['track_title'];
		$trackalbum = $row['album_title'];
		$ualbumartist = urlencode($albumartist);
		$utrackartist = urlencode($trackartist);
		$utrackname = urlencode($trackname);
		$utrackalbum = urlencode($trackalbum);
			echo '<tr>';
			echo "<td><a href='artistview.php?artist=$aaid'>$aaname</a></td>";
			if (!isset($_SESSION['currentlist'])){
				echo "<td><a href='artistview.php?artist=$artistid'>$trackartist</a></td>";
			} else {
			echo "<td><a href='refined.php?req=trackartist&query=$utrackartist'>$trackartist</a></td>";
		}
			echo "<td><a href='refined.php?req=tracktitle&query=$utrackname'>$trackname</a></td>";
			echo "<td><a href='albumview.php?req=albumid&query=$albumid'>$trackalbum</a> (".$row['album_collection'].")</td>";
			echo "</tr>\n";
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