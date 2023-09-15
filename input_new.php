<?php
// statican music - code for database inserts
//set up includes
include('connected.php');
include('functions.php');
include('header.php');
include('includes/dbinsert.php');
include('includes/spotify.php');
// print_r($_POST);
// echo "<br>";
if ($_POST['submit'] == "Add Album") {
//assign POST values to variables
$albumArtist = $_POST['albumArtist'];
$artistId = $_POST['hdnId'];
$sortArtist = $_POST['sortArtist'];
$sartist = $_POST['sartist'];
$albumTitle = $_POST['albumTitle'];
$albumCollection = $_POST['albumCollection'];
$trackInfo = $_POST['trackInfo'];

//initiate other variables
$albumSortTitle = "";
$albumCover = "";
$trackOrder = 0;

// DO ARTIST LOGIC
	if ($artistId != "") {
		//no insert required
		echo "Artist $albumArtist ($artistId) already in database";
	 if ($sortArtist != "NULL") {
	//SORT ARTIST - UPDATE SORT ARTIST
	 	include('includes/dbupdate.php');
			$sortReturn = updateArtistSortName($sortArtist, $artistId);
			echo "<p>Updated Sort Artist</p>";
	}
}
	 else {
	//INSERT ARTIST
			//function inserts artist and returns new id value
			$artistId = addArtist($albumArtist, $sortArtist);
			echo "<p class='text-primary'>Artist $albumArtist ($artistId) ADDED</p>";

	}

// DO ALBUM LOGIC
	//check if album title starts with The 
	if (preg_match('/^The (.*)/',$albumTitle, $match)) {
		//create sort title with ,The at the end
		$albumSortTitle = "$match[1], The";
	} else {
		$albumSortTitle = $albumTitle;
	}
	// get album cover for front page display call spotify API in function spotifyCover
	if ($albumCollection == "dlibrary" || $albumCollection == "itunes" || $albumCollection == "vinyl") {
		$spotifyCovers = spotifyIdCover($albumTitle, $albumArtist);
		if (preg_match("/ - /", $spofifyCovers)) {
		$albumCovers = explode(' - ', $spotifyCovers);
		$albumCover = $albumCovers[1]; } else {
		
		}
		if ($albumCover != "") {
			echo "<p>Cover successfully added <a href='$albumCover'>SEE</a></p>";
		} else { echo "<p>No cover found</p>";}
	} else { // end collection check for album cover
		$albumCover = "";
		echo "No cover added - wrong collection";
	}
	//INSERT ALBUM
			//function inserts album and returns new id value
			$albumId = addAlbum($albumTitle, $artistId, $albumSortTitle, $albumArtist, $albumCollection, $albumCover);
			echo "<p>Album $albumTitle ($albumId) ADDED</p>";

//DO TRACK LOGIC
		// split track variable on end-of-line
		$trackex = explode(PHP_EOL,$trackInfo);
		$addid = "";
				// iterate through tracks
				foreach($trackex as $tracks) {

					if ($tracks != "") {
						$trackOrder++;
						$track = explode(' - ',$tracks);
						$trackArtist = $track[0];
						$trackTitle = rtrim($track[1], "\r");
							if (preg_match('/^The (.*)/',$trackTitle, $matkz)) {
							$trackSortTitle = "$matkz[1], The";
							} else {
							$trackSortTitle = $trackTitle;
							}


						} //end check for empty line 
						else {echo "Blank line; no need to add";}

						//GET track artist id logic

						// if the trackartist is the same as the albumartist just use that ID
						if ($trackArtist == $albumArtist) {
							$trackArtistId = $artistId;
						} else {
							// when the trackartist does NOT match the albumartist
							$trackartists = mysqli_real_escape_string($con, $trackArtist);
								$trackartistsand = str_replace(' & ', ' and ', $trackartists);
								$trackartiststhe = preg_replace('/The /', '', $trackartists);
								// $trackartistsdot = rtrim($trackartists, ".");
								$trackartistsdot = $trackartists.".";
								$sql = "select * from artists";
								$sql = $sql . " where artist_name = '$trackartists'";
								$sql = $sql . " or artist_name = 'The $trackartists'";
								$sql = $sql . " or artist_name = '$trackartistsand'";
								$sql = $sql . " or artist_name = '$trackartiststhe'";
								$sql = $sql . " or artist_name = '$trackartistsdot'";
							//	echo "$sql<br>";
								$query = mysqli_query($con,$sql);
								$row_cnt = mysqli_num_rows($query);
								if ($row_cnt > 0){
							    while ($row = $query->fetch_assoc()) {

							    	$tartistid = $row['id'];
							    	$artistmatch = $row['artist_name'];
							    	$artistvisible = $row['artist_visible'];
							    	$artistgolden = $row['artist_golden_id'];
							    	// checks to see if the matched artist is the 'golden' version if not then uses the golden id
							    	if ($artistvisible == 0) {
							    		$trackArtistId = $artistgolden;
							    	} else {
							    		// use the id retrieved from the db if it is the 'golden' version
							     	$trackArtistId = $tartistid;
							     }
							     } //end sql while
							    }//end row_cnt empty check   	echo $row['id'];
							    	else {
							    		//do insert of artist
							    				if (preg_match('/^The (.*)/',$trackArtist, $match)) {
														//create sort title with ,The at the end
														$trackSortArtist = "$match[1], The";
													} else {
														$trackSortArtist = $trackArtist;
													}
							    			$trackArtistId = addArtist($trackArtist, $trackSortArtist);
											echo "<p class='text-danger'>Artist $trackArtist ($trackArtistId) ADDED - please edit sort artist later</p>";
											$addid = $addid ."'$trackArtistId', ";

							    	}
    
						}

						//INSERT TRACK
							//function inserts track and returns success/fail
							// $trackReturn = "OK";	
							if (preg_match('/^The (.*)/',$trackTitle, $matcz)) {
								//create sort title with ,The at the end
								$trackSortTitle = "$matcz[1], The";
							} else {
								$trackSortTitle = $trackTitle;
							}
							 $trackReturn = addTrack($trackSortTitle, $trackTitle, $trackArtistId, $albumId, $trackOrder);	
							if ($trackReturn == "OK") {
								echo "<p> Track $trackSortTitle, $trackTitle, $trackArtistId, $albumId, $trackOrder ADDED</p>";
							} else {
								echo "<p>something went well wrong</p>";
							}
				}// end trackex foreach
				
				if ($addid != "") {
				$addid = rtrim($addid, ', ');
				echo "<a href='input_test.php?art=".urlencode($addid)."'>Edit new artists</a>";

				}


} //END ADD ALBUM
// check if something's been submitted via form to this page else report ERROR
if ($_POST['submit'] == "") {
	echo "ERROR: no values passed";
}
?>