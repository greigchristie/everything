<?php
include("functions.php");
include("connected.php");
$albumid = $_GET['query'];
$various = "";
//echo $getartist;

		$sql1 = "SELECT a.artist_name, b.album_title FROM artists a, albums b";
		$sql1 = $sql1 . " where a.id = b.artist_id";
		$sql1 = $sql1 . " and b.id = \"$albumid\"";
		//echo "<h3>$sql1</h3>";
		$result1 = mysqli_query($con,$sql1);
		while ($row1 = mysqli_fetch_array($result1))
		{
			$albumartist = $row1['artist_name'];
			$albumtitle = $row1['album_title'];
			$ualbumtitle = urlencode($albumtitle);
			$ualbumartist = urlencode($albumartist);
		}

?>
<?php			 
			
			$url = "https://api.spotify.com/v1/search?q=album%3A$ualbumtitle+artist%3A$ualbumartist&type=album&market=gb&limit=5";

			       // echo "service url<pre>";
			       // echo $url."<br />";
			       // echo "</pre>";
			//  Initiate curl
			$ch = curl_init();
			// Disable SSL verification
			//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
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
			

		// Will dump a beauty json :3
		
//		 echo "<pre>";
//		 print_r($results);
//		 echo "</pre>";
//		echo "<p>$available</p>";
		$coverimage = "";
		$spotifyuri = $results->albums->items;
		if (count($spotifyuri) > 0) {
		$spotifyuri = $results->albums->items[0]->uri;
		} else {
		$spotifyuri = "";
		}
		if ($spotifyuri != "") {
		$coverimage = $results->albums->items[0]->images[1]->url;
		}
		//echo $spotifyuri;

include("header.php");			?>

<div class="row"> <!-- row 1 -->
<div class="col-xs-12">
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
	?>





<?php

//Just to see what comments look like!
		$sql = "SELECT a.artist_name, b.album_collection, c.track_title, c.track_artist_id, c.album_artist_id, a.id from artists a, albums b, tracks c";
		$sql = $sql . " where a.id = c.track_artist_id";
		$sql = $sql . " and b.id = album_id";
		$sql = $sql . " and b.id = \"$albumid\"";
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
		echo "<div class='col-xs-8'>";
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
		echo "<div class='row'><div class='col-xs-12'><li>"; //row 3
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
		echo "<div class='col-xs-4 text-center'>";
		if ($coverimage != "") {
		echo "<img src='$coverimage' class='img-responsive'>";
		}
		if ($spotifyuri != "") {
	 echo "<div class='row'>";
	 echo "<div class='col-sm-4 hidden-xs' text-center>";
	 echo "<iframe src=\"https://embed.spotify.com/?uri=$spotifyuri\" width=\"300\" height=\"380\" frameborder=\"0\" allowtransparency=\"true\"></iframe>";
	 echo "</div>";
	 echo "</div>";

		}
		echo "</div>";
		echo "</div>\n"; // end row 2
		echo "<a href='artistview.php?artist=$artistid'>Click to see all albums by $albumartist</a>";
		echo "<p> From $collection collection</p>";
?>
	
<?php
echo totop($row_cnt);
include("footer.php");
?>
