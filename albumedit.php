<?php
include("functions.php");
include("connected.php");
include("includes/spotify.php");
$albumid = $_GET['query'];
$various = "";
//echo $getartist;

		$sql1 = "SELECT a.artist_name, a.id as artistid, b.album_title, b.album_sort_title, b.album_collection, b.album_cover FROM artists a, albums b";
		$sql1 = $sql1 . " where a.id = b.album_artist_id";
		$sql1 = $sql1 . " and b.id = \"$albumid\"";
//		echo "<h3>$sql1</h3>";
		$result1 = mysqli_query($con,$sql1);
		while ($row1 = mysqli_fetch_array($result1))
		{
			$albumartist = $row1['artist_name'];
			$albumartistid = $row1['artistid'];
			$albumtitle = $row1['album_title'];
			$albumsorttitle = $row1['album_sort_title'];
			$albumcollection = $row1['album_collection'];
			if ($row1['album_cover'] != "") {
			$albumcover = $row1['album_cover'];
			} else {
				$albumcover = "Not in database";
			}
		}

?>

<?php			 
$spotifys = spotifyIdCover($albumtitle, $albumartist);
// print_r($spotifys);

$spotify = explode(' - ', $spotifys);
$spotifyuri = $spotify[0];
$coverimage = $spotify[1];

include("header.php");			?>
<script type="text/javascript" src="js/dbjs.js"></script>
<div class="row"> <!-- row 1 -->
<div class="col-12">
<?php
	 echo "<p>Title: <span data-editable id='albumtitle'>$albumtitle</span> <i class=\"fa fa-pencil\" style='font-size: 12pt;'  onclick='editNames(\"$albumid|albumtitle\")'></i>";
	 echo "<span id='sucalbumtitle'></span></p>";
	 echo "<p>Sort Title: <span data-editable id='albumsorttitle'>$albumsorttitle</span> <i class=\"fa fa-pencil\" style='font-size: 12pt;' onclick='editNames(\"$albumid|albumsorttitle\")'></i>";
	 echo "<span id='sucalbumsorttitle'></span></p>";
	 echo "<p>Collection: <span data-editable id='albumcollection'>$albumcollection</span> <i class=\"fa fa-pencil\" style='font-size: 12pt;' onclick='editNames(\"$albumid|albumcollection\")'></i>";
	 echo "<span id='sucalbumcollection'></span></p>";
	 echo "<p>Cover: <span data-editable id='albumcover'>$albumcover</span> <i class=\"fa fa-pencil\" style='font-size: 12pt;' onclick='editNames(\"$albumid|albumcover\")'></i>";
	 	 echo "<span id='sucalbumcover'></span></p>";
	 echo "<p id='albumartist'>Artist: <a href='artistedit.php?artist=$albumartistid&id=$albumid&edit=album'>".$albumartist."</a></p>"; 
	 echo "<p><span class='btn btn-danger' onclick='deleteAlbum(\"$albumid\")'>DELETE ALBUM</span><span id='sucAlbum'></span></p>";
	 echo "</div>";
	 echo "</div>";


	if ($coverimage != "") {
	echo "<p class='d-block d-sm-none text-center'<img src='$coverimage'></p>";
	}
	?>


<!-- </div>
</div> -->


<?php

//Just to see what comments look like!
		$sql = "SELECT a.artist_name, b.album_collection, c.track_title, c.track_artist_id, c.track_order, c.id as cid, b.album_artist_id, a.id from artists a, albums b, tracks c";
		$sql = $sql . " where a.id = c.track_artist_id";
		$sql = $sql . " and b.id = album_id";
		$sql = $sql . " and b.id = \"$albumid\"";
		$sql = $sql . " and c.track_owned = 1";
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
		// echo "<ol>";
		$row_cnt = mysqli_num_rows($result);
		while ($row = mysqli_fetch_array($result))
		{
		$track_artist_id = $row['track_artist_id'];
		$album_artist_id = $row['album_artist_id'];
		$trackartist = $row['artist_name'];
		$tracktitle = $row['track_title'];
		$collection = $row['album_collection'];
		$artistid = $row['id'];
		$trackid = $row['cid'];
		$trackorder = $row['track_order'];
		$utrackartist = urlencode($trackartist);
		$utracktitle = urlencode($tracktitle);

                $ualbumartist = urlencode($albumartist);
                if ($album_artist_id != $track_artist_id) { $various = "true"; } else { $various = "false"; }
		echo "<div class='row'><div class='col-12'><span data-editable id='trackorder$trackid'>$trackorder</span> "; //row 3
		echo "<i class=\"fa fa-pencil\" style='font-size: 12pt;' onclick='editNames(\"$trackid|trackorder$trackid\")'></i>";
			 echo "<span id='suctrackorder$trackid'></span>";
		 if($various == "true") {
			echo "<span id='trackartist'><a href='artistedit.php?artist=$artistid&id=$trackid&edit=track'>$trackartist</a></span>";
			echo " - ";
			} 
			echo "<span data-editable id='tracktitle$trackid'>$tracktitle</span> ";
			echo "<i class=\"fa fa-pencil\" style='font-size: 12pt;' onclick='editNames(\"$trackid|tracktitle$trackid\")'></i>";
			echo " <i class=\"fa fa-times-circle\" style='font-size: 1.2em; color: red;' onclick='deleteNames(\"$trackid|tracktitle$trackid\")'></i>";
			echo "<span id='suctracktitle$trackid'></span>";
		echo "</div></div>\n"; //end row 3
		}
		// echo "</ul>";
		echo "</div>";
		echo "<div class='col-4 hidden-xs text-center'>";
		if ($coverimage != "") {
		echo "<img src='$coverimage' class='img-responsive'>";
		}
		if ($spotifyuri != "") {

	 // echo "<iframe src=\"https://embed.spotify.com/?uri=$spotifyuri\" width=\"300\" height=\"380\" frameborder=\"0\" allowtransparency=\"true\"></iframe>";


		}
		echo "</div>";
		echo "</div>\n"; // end row 2
		echo "<p>&nbsp;</p><a href='artistview.php?artist=$albumartistid'>Click to see all albums by $albumartist</a>";
		echo "<p> From $collection collection</p>";

?>

<script>
/**
  We're defining the event on the `body` element, 
  because we know the `body` is not going away.
  Second argument makes sure the callback only fires when 
  the `click` event happens only on elements marked as `data-editable`
*/
$('body').on('click', '[data-editable]', function(){
  
  var $el = $(this);
  var $fieldId = $(this).attr('id');              
  var $input = $('<input/>').val( $el.text() );
  $el.replaceWith( $input );
  
  var save = function(){
    var $p = $('<span data-editable />').text( $input.val() ).attr('id', $fieldId);
    $input.replaceWith( $p );
  };
  
  /**
    We're defining the callback with `one`, because we know that
    the element will be gone just after that, and we don't want 
    any callbacks leftovers take memory. 
    Next time `p` turns into `input` this single callback 
    will be applied again.
  */
  $input.one('blur', save).focus();
  
});
</script>	
<?php
echo totop($row_cnt);
		echo "<p><a href='albumview.php?req=albumid&query=$albumid'>View</a></p>";
include("footer.php");
?>
