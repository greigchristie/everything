<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//This include contains all the db update functions

// ARTIST UPDATES
// update artist (not visibile or golden - visible has a default value and golden is only set when you create a golden artist id)
	function updateArtist($artistName, $artistSortName, $artistId) {
	require('connected.php');
			$artistUpdate = "UPDATE artists SET artist_name = ?, artist_sort_name = ? where id =?";
			$insertStmt = $con->prepare($artistUpdate);
			//EXECUTE INSERT
		    	$insertStmt->bind_param('ssi', $artistName, $artistSortName, $artistId);
    			$insertStmt->execute();
// 			$artistId = $con->insert_id;

	}

// update artist name only
	function updateArtistName($artistName, $artistId) {
	require('connected.php');
			$artistNameUpdate = "UPDATE artists SET artist_name = ? where id = ?";
			$insertStmt = $con->prepare($artistNameUpdate);
			//EXECUTE INSERT
		    	$insertStmt->bind_param('si', $artistName, $artistId);
    			$insertStmt->execute();
// 			$artistId = $con->insert_id;
	}

// update sort_artist only
	function updateArtistSortName($sortArtistName, $artistId) {
	require('connected.php');
			$artistSortUpdate = "UPDATE artists SET artist_sort_name = ? where id = ?";
			$insertStmt = $con->prepare($artistSortUpdate);
			//EXECUTE INSERT
		    	$insertStmt->bind_param('si', $sortArtistName, $artistId);
    			$insertStmt->execute();

	}
	
// update alt_artist only
	function updateArtistAltName($altArtistId, $artistId) {
	require('connected.php');
			$altArtistId = (int)$altArtistId;
			$artistAltUpdate = "UPDATE artists SET artist_alt_id = ? where id = ?";
			if ($insertStmt = $con->prepare($artistAltUpdate)) {
			//EXECUTE INSERT
			
		    	$insertStmt->bind_param('ii', $altArtistId, $artistId);
    			$insertStmt->execute();
			} else {
			$error = $con->errno . ' ' . $con->error;
			echo $error;
			}
	}



// ALBUM UPDATES
// update album
	function updateAlbum($albumTitle, $albumSortTitle, $albumArtistName, $albumCollection, $albumArtistId, $albumCover, $albumId) {

	}

// update album title
	function updateAlbumTitle($albumTitle, $albumId) {
		require('connected.php');
			$albumTitleUpdate = "UPDATE albums SET album_title = ? where id = ?";
			$insertStmt = $con->prepare($albumTitleUpdate);
			//EXECUTE INSERT
		    	$insertStmt->bind_param('si', $albumTitle, $albumId);
    			$insertStmt->execute();

	}

// update album sort title
	function updateAlbumSortTitle($albumSortTitle, $albumId) {
		require('connected.php');
			$albumSortTitleUpdate = "UPDATE albums SET album_sort_title = ? where id = ?";
			$insertStmt = $con->prepare($albumSortTitleUpdate);
			//EXECUTE INSERT
		    	$insertStmt->bind_param('si', $albumSortTitle, $albumId);
    			$insertStmt->execute();
	}

// update album artist name
	function updateAlbumArtistName($albumArtistName, $albumId) {
		require('connected.php');
			$albumTitleUpdate = "UPDATE albums SET album_artist_name = ? where id = ?";
			$insertStmt = $con->prepare($albumTitleUpdate);
			//EXECUTE INSERT
		    	$insertStmt->bind_param('si', $albumArtistName, $albumId);
    			$insertStmt->execute();
	}

// update album collection
	function updateAlbumCollection($albumCollection, $albumId) {
		require('connected.php');
			$albumCollectionUpdate = "UPDATE albums SET album_collection = ? where id = ?";
			$insertStmt = $con->prepare($albumCollectionUpdate);
			//EXECUTE INSERT
		    	$insertStmt->bind_param('si', $albumCollection, $albumId);
    			$insertStmt->execute();
	}

// update album artist id
	function updateAlbumArtistId($albumArtistId, $albumId) {
		require('connected.php');
			$albumArtistIdUpdate = "UPDATE albums SET album_artist_id = ? where id = ?";
			$insertStmt = $con->prepare($albumArtistIdUpdate);
			//EXECUTE INSERT
		    	$insertStmt->bind_param('ii', $albumArtistId, $albumId);
    			$insertStmt->execute();
	}

// update album cover
	function updateAlbumCover($albumCover, $albumId) {
		require('connected.php');
			$albumCoverUpdate = "UPDATE albums SET album_cover = ? where id = ?";
			$insertStmt = $con->prepare($albumCoverUpdate);
			//EXECUTE INSERT
		    	$insertStmt->bind_param('si', $albumCover, $albumId);
    			$insertStmt->execute();
	}


// TRACK UPDATES
// update track
	function updateTrack($trackTitle, $trackSortTitle, $trackArtistId, $albumId, $trackOrder, $trackId) {

	}

// update track title
	function updateTrackTitle($trackTitle, $trackId){
		require('connected.php');
			$trackTitleUpdate = "UPDATE tracks SET track_title = ? where id = ?";
			$insertStmt = $con->prepare($trackTitleUpdate);
			//EXECUTE INSERT
		    	$insertStmt->bind_param('si', $trackTitle, $trackId);
    			$insertStmt->execute();
	}
// update track title
	function updateTrackSortTitle($trackSortTitle, $trackId){
		require('connected.php');
			$trackSortTitleUpdate = "UPDATE tracks SET track_sort_title = ? where id = ?";
			$insertStmt = $con->prepare($trackSortTitleUpdate);
			//EXECUTE INSERT
		    	$insertStmt->bind_param('si', $trackSortTitle, $trackId);
    			$insertStmt->execute();
	}
// update track order
	function updateTrackOrder($trackOrder, $trackId){
		require('connected.php');
			$trackOrderUpdate = "UPDATE tracks SET track_order = ? where id = ?";
			$insertStmt = $con->prepare($trackOrderUpdate);
			//EXECUTE INSERT
		    	$insertStmt->bind_param('ii', $trackOrder, $trackId);
    			$insertStmt->execute();
	}

// update track artist
	function updateTrackArtist($trackArtistId, $trackId){
		require('connected.php');
			$trackArtistUpdate = "UPDATE tracks SET track_artist_id = ? where id = ?";
			$insertStmt = $con->prepare($trackArtistUpdate);
			//EXECUTE INSERT
		    	$insertStmt->bind_param('ii', $trackArtistId, $trackId);
    			$insertStmt->execute();
	}

// consolidate artist (assign all tracks/albums to chosen golden artist by replacing non golden ids)
// requires existing artist id and the golden artist id.
	function consolidateArtist($artistId, $goldenArtistId, $artistName) {
	require('connected.php');
		$zero = 0;
	
		// Update tracks to 'golden' artistid
		$track2golden = "update tracks set track_artist_id = ? where track_artist_id = ?";
		$insertStmt = $con->prepare($track2golden);
		//EXECUTE UPDATE
		$insertStmt->bind_param('ii', $goldenArtistId, $artistId);
    		$insertStmt->execute();
 		
		//update albums to 'golden' artistid
		$album2golden = "update albums set album_artist_id = ? where album_artist_id = ?";
		$insertsStmt = $con->prepare($album2golden);
		//EXECUTE UPDATE
		$insertsStmt->bind_param('ii', $goldenArtistId, $artistId);
    		$insertsStmt->execute();

    	//update album artist name
    	$artistNameUpdate = "UPDATE albums SET album_artist_name = ? where album_artist_id = ?";
		$insertStmt = $con->prepare($artistNameUpdate);
		//EXECUTE INSERT
		    	$insertStmt->bind_param('si', $artistName, $goldenArtistId);
    			$insertStmt->execute();
	
		$artist2invisible = "update artists set artist_visible = ?, artist_golden_id = ? where id = ?";
		$insertzStmt = $con->prepare($artist2invisible);
		//EXECUTE UPDATE
		$insertzStmt->bind_param('iii', $zero, $goldenArtistId, $artistId);
    		$insertzStmt->execute();
    		
    		return "DONE";

	}


?>