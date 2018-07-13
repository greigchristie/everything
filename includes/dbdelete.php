<?php
// db 'deletes' actually they're updates but they effectively remove artists, albums and tracks from display and use in the app

// artist 'delete' BE AWARE: this is to just remove an artist from display - does not set another (GOLDEN) artist for display
	function deleteArtist($artistId) {
			$zero = 0;
			$delArtist = "UPDATE artists SET artist_visible = ? where id = ?";
	}

// album 'delete'.
	function deleteAlbum($albumId) {
		require('../connected.php');
			$zero = 0;
			$delTrack = "UPDATE tracks SET track_owned = ? where album_id = ?";
		if 	($insertStmt = $con->prepare($delTrack)){
			//EXECUTE UPDATE
		    $insertStmt->bind_param('ii', $zero, $albumId);
    		$insertStmt->execute();
    		// return('y');
 			} else {
    		$error = $con->errno . ' ' . $con->error;
 		   
			}
			$delAlbum = "UPDATE albums SET album_owned = ? where id = ?";
			if 	($insertStmt = $con->prepare($delAlbum)){
			//EXECUTE UPDATE
		    $insertStmt->bind_param('ii', $zero, $albumId);
    		$insertStmt->execute();
    		return('y');
			 } else {
		    $error_albums = $con->errno . ' ' . $con->error;
		    $error = $error . $error_albums;
		    return($error);
			}
	}

// track 'delete'
	function deleteTrack($trackId) {
		require('../connected.php');
			$zero = 0;
			$delTrack = "UPDATE tracks SET track_owned = ? where id = ?";
		if 	($insertStmt = $con->prepare($delTrack)){
			//EXECUTE UPDATE
		    $insertStmt->bind_param('ii', $zero, $trackId);
    		$insertStmt->execute();
    		return('y');
 } else {
    $error = $con->errno . ' ' . $con->error;
    return($error);
}

	}
	
// album 'undelete'.
	function unDeleteAlbum($albumId) {
		require('../connected.php');
			$one = 1;
			$delTrack = "UPDATE tracks SET track_owned = ? where album_id = ?";
		if 	($insertStmt = $con->prepare($delTrack)){
			//EXECUTE UPDATE
		    $insertStmt->bind_param('ii', $one, $albumId);
    		$insertStmt->execute();
    		// return('y');
 			} else {
    		$error = $con->errno . ' ' . $con->error;
 		   
			}
			$delAlbum = "UPDATE albums SET album_owned = ? where id = ?";
			if 	($insertStmt = $con->prepare($delAlbum)){
			//EXECUTE UPDATE
		    $insertStmt->bind_param('ii', $one, $albumId);
    		$insertStmt->execute();
    		return('y');
			 } else {
		    $error_albums = $con->errno . ' ' . $con->error;
		    $error = $error . $error_albums;
		    return($error);
			}
	}
	
// track 'undelete'
	function unDeleteTrack($trackId) {
		require('../connected.php');
			$one = 1;
			$delTrack = "UPDATE tracks SET track_owned = ? where id = ?";
		if 	($insertStmt = $con->prepare($delTrack)){
			//EXECUTE UPDATE
		    $insertStmt->bind_param('ii', $one, $trackId);
    		$insertStmt->execute();
    		return('y');
 } else {
    $error = $con->errno . ' ' . $con->error;
    return($error);
}

	}
?>