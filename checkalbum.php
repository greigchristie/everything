<?php
//include("connected.php");
include("functions.php");
include("connected.php");
include('header.php');
?>
<script>
$(function() {
    // $( "#albumArtist" ).autocomplete({
    //     source: 'autoc.php',
    //     minLength: 2
    //   });
    $( "#albumArtist" ).autocomplete({
        source: 'autoc.php',
        minLength: 2,
        focus: function(event, ui) {
          event.preventDefault();
          $(this).val(ui.item.value);
        },
        select: function (event, ui) {
          event.preventDefault();
          $(this).val(ui.item.name);
          $("#sortArtist").val(ui.item.value);
          $("#sartist").val(ui.item.value);
          $("#hdnId").val(ui.item.id);//Put Id in a hidden field
          // return false;
        }
    });
});
</script>
<h2>Check album</h2>
<?php
$barcode = "";
$catno = "";
$titleartist = "";
if (isset($_POST['barcode'])) {
$barcode = $_POST['barcode'];
}
if (isset($_POST['catno'])) {
$catno = $_POST['catno'];
}
if (isset($_POST['title'])) {
$titleartist = $_POST['title'];
$itemtype = "titleartist";
}
$searchtype = "";
$searchvalue = "";
if ($barcode != "") {
$searchvalue = $_POST['barcode'];
$searchtype = "barcode";
$itemtype = "barcode";
}
if ($catno != "") {
$searchvalue = $_POST['catno'];
$searchtype = "catno";
$itemtype = "catno";
}
$albumtitle = "";
 $token = getenv('DISCOGS_TOKEN');
//  $url = "https://api.spotify.com/v1/search?query=track%3A".$utrackname."+artist%3A".$utrackartist."&market=gb&offset=0&limit=5&type=track";
if ($itemtype == "titleartist"){
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
 //echo "<pre>";
 //var_dump(json_decode($resulz, true));
 //echo "</pre>";

$resulzs = json_decode($resulz);
// check to see if artist name has a (number) after and get rid of it.
$albumartist = $resulzs->artists[0]->name;
    if (preg_match('/(.*)( )(\(\d+\))/', $albumartist, $matches)) {
      // print_r($matches);
      $albumartist = $matches[1];
      }
$tracks = $resulzs->tracklist;
//print_r($tracks);
// echo "album: ".$albumtitle."<br>";
if ($albumtitle == "") {
  $albumtitle = $resulzs->title; 
// echo "<p>ablum: $albumtitle</p>";
}
if ($albumartist == "Various") { $albumartist = "Various Artists"; }
    $sql = "SELECT id, artist_sort_name from artists where artist_name = '$albumartist' and artist_visible = 1";
    $result = mysqli_query($con,$sql);
    // $row_cnt = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result))
    { $artistid = $row['id'];
      $sortartist = $row['artist_sort_name'];
     }
?>
<form role="form" action="input_new.php" method="post">
<div class="row">
  <div class="form-group  col-md-4">
    <label for="albumArtist">Album Artist</label>
    <input type="text" class="form-control input-medium" id="albumArtist" name="albumArtist" value="<?php echo $albumartist; ?>">
   <input type="text"  name="hdnId" id="hdnId" value="<?php echo $artistid; ?>">

  </div>
</div>
<div class="row">
  <div class="form-group  col-md-4">
    <label for="sortArtist">Sort Artist</label>
    <input type="text" class="form-control input-medium" id="sortArtist" name="sortArtist" value="<?php echo $sortartist; ?>">
    <input type='hidden' id="sartist" name='sartist' value=''>
  </div>
</div>
<div class="row">
  <div class="form-group  col-md-4">
    <label for="albumTitle">Album Title</label>
    <input type="text" class="form-control input-medium" id="albumTitle" name="albumTitle" value="<?php echo $albumtitle; ?>">
  </div>
</div>
<div class="row">
  <div class="form-group  col-md-4">
    <label for="albumCollection">Album Collection</label>
    <select class="form-control" name="albumCollection" id="albumCollection">
    		<option>coverdisc</option>
		<option value='dlibrary' <?php if ($itemtype == "barcode"){ echo "selected";}?>>dlibrary</option>
    <option value='itunes' <?php if ($itemtype == "titleartist"){ echo "selected";}?>>itunes</option>
		<option value='vinyl' <?php if ($itemtype == "catno"){ echo "selected";}?>>vinyl</option>
    <option value='cdsingle'>cdsingle</option>
	</select>
  </div>

</div>
<?php
$alltracks = "";
   foreach ($tracks as $track) {
//print_r($track->artists);
//echo "<br>";
      $tracktitle = $track->title;
      if (isset($track->artists)) {
        
      $trackartist = $track->artists[0]->name;
      
    }
if ($albumartist != "Various Artists") {
$trackline = $albumartist ." - " . $tracktitle . PHP_EOL;
$alltracks = $alltracks . $trackline;
} else {
//      if (preg_match('/(.*)( )(\(\d+\))/', $trackartist, $matches)) {
//       print_r($matches);
//      $trackartist = $matches[1];
//      }
//	print_r($trackartist);
      if (preg_match('/(.*)( )(\(\d+\))/', $trackartist, $matches)) {
      // print_r($matches);
      $trackartist = $matches[1];
      }
	$trackline =  $trackartist . " - " . $tracktitle . PHP_EOL;
	$alltracks = $alltracks . $trackline;
}
}?>
    <div class="row">
  <div class="form-group col-md-5">
        <label for="trackInfo">Track Info</label>
    <textarea class="form-control" rows="15" name="trackInfo">
<?php
//		echo 
		echo rtrim($alltracks);
		?>
</textarea>
    </div>
    </div>
  <button type="submit" class="btn" name="submit" value="Add Album">Add Album</button> 

  </form>

  <?php 
} else {	echo "<h2>No Match Found</h2>";}
  ?>
<?php 
include('footer.php');
?>