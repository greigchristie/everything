<?php
//This include contains all the db insert functions

function addArtist($albumArtist, $sortArtist) {
			include('connected.php');
			$zero = 0;
			//PREPARE ARTIST INSERT STATEMENT
			$insert = 'INSERT INTO artists (artist_name, artist_sort_name, artist_golden_id) VALUES (?,?,?)';
			$insertStmt = $con->prepare($insert);
			//EXECUTE INSERT
		    $insertStmt->bind_param('ssi', $albumArtist, $sortArtist, $zero);
    		$insertStmt->execute();
 			$artistId = $con->insert_id;

 			// $goldenadd = 'UPDATE artists SET artist_golden_id=? WHERE id =?';
 			// $insertGold = $con->prepare($goldenadd);
 			// //EXECUTE STATEMENT
 			// $insertGold->bind_param('ii', $artistId, $artistId);
 			// $insertGold->execute();

 			return $artistId;
	}

	function addAlbum($albumTitle, $artistId, $albumSortTitle, $albumArtist, $albumCollection, $albumCover) {
			include('connected.php');
			//PREPARE ALBUM INSERT STATEMENT
			$insertz = 'INSERT INTO albums (album_title, album_artist_id, album_sort_title, album_artist_name, album_collection, album_cover) VALUES(?,?,?,?,?,?)';
			$insertzStmt = $con->prepare($insertz);
			//EXECUTE INSERT
			$insertzStmt->bind_param('sissss', $albumTitle, $artistId, $albumSortTitle, $albumArtist, $albumCollection, $albumCover);
			$insertzStmt->execute();
			$albumId = $con->insert_id;
			return $albumId;
	}

	function addTrack($trackSortTitle, $trackTitle, $trackArtistId, $albumId, $trackOrder) {
		include('connected.php');
		//PREPARE TRACK INSERT STATEMENT
		$inserts = 'INSERT INTO tracks (track_sort_title, track_title, track_artist_id, album_id, track_order) VALUES (?,?,?,?,?)';
		$insertsStmt = $con->prepare($inserts);
		//EXECUTE INSERT
		$insertsStmt->bind_param('ssiii', $trackSortTitle, $trackTitle, $trackArtistId, $albumId, $trackOrder);
		$insertsStmt->execute();
		return "OK";
	}

?>