<?php
// print_r($_POST);
include('includes/dbinsert.php');
include('includes/spotify.php');
include('spauth.php');
include('header.php');

// Assign one-off variables.
$albumArtist = $_POST['albumArtist'];
$albumArtistId = $_POST['hdnId'];
$albumSortArtist = $_POST['albumSortArtist'];
$albumTitle = $_POST['albumTitle'];
$albumCollection = $_POST['albumCollection'];

// DO ARTIST LOGIC
	if ($albumArtistId != "") {
		//no insert required
		echo "Artist $albumArtist ($albumArtistId) already in database";
	 if ($albumSortArtist != "NULL") {
	//SORT ARTIST - UPDATE SORT ARTIST
	 	include('includes/dbupdate.php');
			$sortReturn = updateArtistSortName($albumSortArtist, $albumArtistId);
			echo "<p>Updated Sort Artist</p>";
	}
}
	 else {
	//INSERT ARTIST
			//function inserts artist and returns new id value
			$artistId = addArtist($albumArtist, $albumSortArtist);
			echo "<p class='text-primary'>Artist $albumSortArtist ($albumArtistId) ADDED</p>";

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
		$albumCovers = explode(' - ', $spotifyCovers);
		$albumCover = $albumCovers[1];
		if ($albumCover != "") {
			echo "<p>Cover successfully added <a href='$albumCover'>SEE</a></p>";
		} else { echo "<p>No cover found</p>";}
	} else { // end collection check for album cover
		$albumCover = "";
		echo "No cover added - wrong collection";
	}
	//INSERT ALBUM
			//function inserts album and returns new id value
			$albumId = addAlbum($albumTitle, $albumArtistId, $albumSortTitle, $albumArtist, $albumCollection, $albumCover);
			echo "<p>Album $albumTitle ($albumId) ADDED</p>";

// set counter for tracks
				$trackCount = count($_POST['trackNo']) - 1;
				
				for ($x = 0; $x <= $trackCount; $x++) {
				
				$trackOrder = $_POST['trackNo'][$x];
				$trackArtist = $_POST['trackArtist'][$x];
				$trackSortArtist = $_POST['sortArtist'][$x];
				$trackTitle = $_POST['trackTitle'][$x];
				$trackArtistId = $_POST['artistId'][$x];

						//INSERT TRACK
							//function inserts track and returns success/fail
							// $trackReturn = "OK";	
							if (preg_match('/^The (.*)/',$trackTitle, $matcz)) {
								//create sort title with ,The at the end
								$trackSortTitle = "$matcz[1], The";
							} else {
								$trackSortTitle = $trackTitle;
							}
							
							if ($trackArtistId == "") {
						$trackArtistId = addArtist($trackArtist, $trackSortArtist);
						echo "<p class='text-primary'>Artist $albumSortArtist ($albumArtistId) ADDED</p>";							  
							}
							
							 $trackReturn = addTrack($trackSortTitle, $trackTitle, $trackArtistId, $albumId, $trackOrder);	
							if ($trackReturn == "OK") {
								echo "<p> Track $trackSortTitle, $trackTitle, $trackArtistId, $albumId, $trackOrder ADDED</p>";
							} else {
								echo "<p>something went well wrong</p>";
							}

}

include('footer.php');
?>