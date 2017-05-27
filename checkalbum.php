<?php
include("connected.php");
include("functions.php");
include('header.php');
?>
<h2>Check album</h2>
<?php
$barcode = "";
$catno = "";
$titleartist = "";
$barcode = $_POST['barcode'];
$catno = $_POST['catno'];
$titleartist = $_POST['title'];
$searchtype = "";
$searchvalue = "";
if (isset($barcode)) {
$searchvalue = $_POST['barcode'];
$searchtype = "barcode";
}
if (isset($catno)) {
$searchvalue = $_POST['catno'];
$searchtype = "catno";
}
$albumtitle = "";
 $token = getenv('DISCOGS_TOKEN');
//  $url = "https://api.spotify.com/v1/search?query=track%3A".$utrackname."+artist%3A".$utrackartist."&market=gb&offset=0&limit=5&type=track";
if (isset($titleartist)){
  $releaseId = $_POST['hdnId'];  
} else {

 $url = "https://api.discogs.com/database/search?$searchtype=$searchvalue&token=$token";

      // echo "service url<pre>";
      // echo $url."<br />";
      // echo "</pre>";
//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'everythingMusic/2.0 +http://every-thing.co.uk');
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
// echo "<pre>";
// var_dump($results);
// echo "</pre>"; 

$releaseId = $results->results[0]->id;
// $albumtitle = $results->results[0]->title;
//echo "<p>$releaseId</p>";
//echo "<p>$albumtitle</p>";
}

if ($releaseId != "") {
 $url = "https://api.discogs.com/releases/$releaseId";
       // echo "service url<pre>";
       // echo $url."<br />";
       // echo "</pre>";
//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'everythingMusic/2.0 +http://every-thing.co.uk');
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$resulz=curl_exec($ch);
//  echo "<pre>";
//  var_dump(json_decode($resulz, true));
//  echo "</pre>";

$resulzs = json_decode($resulz);
// check to see if artist name has a (number) after and get rid of it.
$albumartist = $resulzs->artists[0]->name;
    if (preg_match('/(.*)( )(\(\d+\))/', $albumartist, $matches)) {
      // print_r($matches);
      $albumartist = $matches[1];
      }
$tracks = $resulzs->tracklist;
// echo "album: ".$albumtitle."<br>";
if ($albumtitle == "") {
  $albumtitle = $resulzs->title; 
// echo "<p>ablum: $albumtitle</p>";
}
if ($albumartist == "Various") { $albumartist = "Various Artists"; }
$query = $con->query("SELECT id FROM artists WHERE artist_name = '$albumartist'");
    while ($row = $query->fetch_assoc()) {
      $artistId = $row['id'];
    }
?>
<form role="form" action="input.php" method="post">
<div class="row">
  <div class="form-group  col-md-4">
    <label for="albumArtist">Album Artist</label>
    <input type="text" class="form-control input-medium" id="albumArtist" name="albumArtist" value="<?php echo $albumartist; ?>">
    <input type="hidden"  name="hdnId" value="<?php echo $artistId; ?>">
    <input type="hidden"  name="albumid" value="">
  </div>
</div>
<div class="row">
  <div class="form-group  col-md-4">
    <label for="sortArtist">Sort Artist</label>
    <input type="text" class="form-control input-medium" id="sortArtist" name="sortArtist" value="<?php echo $albumartist; ?>">
  </div>
</div>
<div class="row">
  <div class="form-group  col-md-4">
    <label for="albumTitle">Album Title</label>
    <input type="text" class="form-control input-medium" id="albumTitle" name="albumTitle" value="<?php echo $albumtitle; ?>">
    <input type="hidden" name="oalbumTitle" value="<?php echo $albumtitle; ?>">
  </div>
</div>
<div class="row">
  <div class="form-group  col-md-4">
    <label for="albumCollection">Album Collection</label>
    <select class="form-control" name="albumCollection" id="albumCollection">
    		<option>coverdisc</option>
		<option selected>dlibrary</option>
		<option>cdsingle</option>
		<option>itunes</option>
	</select>
  </div>

</div>
    <div class="row">
  <div class="form-group col-md-5">
        <label for="trackInfo">Track Info</label>
    <textarea class="form-control" rows="15" name="trackInfo">
<?php
   foreach ($tracks as $track) {
//print_r($track->artists);
//echo "<br>";
      $tracktitle = $track->title;
      $trackartist = $track->artists[0]->name;
if ($albumartist != "Various Artists") {

echo $albumartist ." - " . $tracktitle . "\n";
} else {
      if (preg_match('/(.*)( )(\(\d+\))/', $trackartist, $matches)) {
      // print_r($matches);
      $trackartist = $matches[1];
      }

	echo $trackartist . " - " . $tracktitle . "\n";
}
}
		
		?>
</textarea>
    </div>
    </div>
  <button type="submit" class="btn" name="button">Build</button> 

  </form>

  <?php 
} else {	echo "<h2>No Match Found</h2>";}
  ?>
<?php 
include('footer.php');
?>