<?php 
$trackname = $_GET['track'];
$trackartist = $_GET['artist'];
include("functions.php");
include("header.php");
?>


<h2><?php echo "$trackname by $trackartist"; ?></h2>
<?php

$utrackname = urlencode($trackname);
$utrackartist = urlencode($trackartist);
//echo "<p>".$trackartist." - ".$trackname."</p>";

 $url = "https://api.spotify.com/v1/search?query=track%3A".$utrackname."+artist%3A".$utrackartist."&market=gb&offset=0&limit=5&type=track";
//       echo "service url<pre>";
//       echo $url."<br />";
//       echo "</pre>";
//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result=curl_exec($ch);
// Closing
curl_close($ch);





// Will dump a beauty json :3

// echo "<pre>";
// var_dump(json_decode($result, true));
// echo "</pre>";
$results = json_decode($result);
$spotifyuri = $results->tracks->items;
if (count($spotifyuri) > 0) {
//	echo "<pre>";
//	print_r($spotifyuri);
//	echo "</pre>";
		$spotifyuri = $results->tracks->items[0]->uri;
	//echo $spotifyuri;
		} else {
		$spotifyuri = "";
		}
if ($spotifyuri == "") {
echo "<h3>Track not found on Spotify</h3>";
} else {
$spotname = $results->tracks->items[0]->album->name;
echo "<p>Click on cover image to play $trackname from the album $spotname in Spotify:<br>";
//echo $result->tracks->href;
echo "<a href=\"";
echo $results->tracks->items[0]->uri;
echo "\">";
echo "<img src='".$results->tracks->items[0]->album->images[1]->url."'>";
echo "</a>";
echo "</p>";
}
?>
<iframe src="https://embed.spotify.com/?uri=<?php echo $spotifyuri; ?>" width="300" height="380" frameborder="0" allowtransparency="true"></iframe>
<?php
// echo "<pre>";
// print_r($results);
// echo "</pre>";
include("footer.php");
?>
