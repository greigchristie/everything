<?php

// print_r($_POST);
if (isset($_POST['method'])) {
	if (isset($_POST['elId'])) {
	$fieldvalue = explode('|',$_POST['elId']);
	$field = $fieldvalue[0];
	$value = $fieldvalue[1];
	}
	$editId = $_POST['postId'];
	$method = $_POST['method'];

	if ($method == "update") {
require('includes/dbupdate.php');
		if($field == "albumtitle") {
			$update = updateAlbumTitle($value, $editId);
			echo " <i class=\"fa fa-check\" style='font-size: 1.2em; color: green;' ></i>";
		}
		if($field == "albumsorttitle") {
			$update = updateAlbumSortTitle($value, $editId);
			echo " <i class=\"fa fa-check\" style='font-size: 1.2em; color: green;' ></i>";
		}
		if($field == "albumcollection") {
			if ($value == 'dlibrary' || $value == 'coverdisc' || $value == 'itunes' || $value == 'vinyl' || $value == 'cdsingle') {
			$update = updateAlbumCollection($value, $editId);
			echo " <i class=\"fa fa-check\" style='font-size: 1.2em; color: green;' ></i>";
			} else {echo "Invalid value";}
		}
		if($field == "albumcover") {
			$value = $value;
			$update = updateAlbumCover($value, $editId);
			echo " <i class=\"fa fa-check\" style='font-size: 1.2em; color: green;' ></i>";
		}
		if(preg_match('/tracktitle/', $field)) {
			$update = updateTrackTitle($value, $editId);
			echo " <i class=\"fa fa-check\" style='font-size: 1.2em; color: green;' ></i>";
		}
		if(preg_match('/trackorder/', $field)) {
			$update = updateTrackOrder($value, $editId);
			echo " <i class=\"fa fa-check\" style='font-size: 1.2em; color: green;' ></i>";		}
		if($field == "artistname") {
			// $value = urlencode($value);
			$update = updateArtistName($value, $editId);
			echo " <i class=\"fa fa-check\" style='font-size: 1.2em; color: green;' ></i>";
		}
		if($field == "artistsortname") {
			// $value = urlencode($value)
			$update = updateArtistSortName($value, $editId);
			echo " <i class=\"fa fa-check\" style='font-size: 1.2em; color: green;' ></i>";
		}
	}

	if ($method == "delete") {
require('includes/dbdelete.php');
		if(preg_match('/tracktitle/', $field)) {
			$update = deleteTrack($editId);
			echo $update;
			// echo " <i class=\"fa fa-check\" style='font-size: 1.2em; color: red;' ></i>";
		}

	}

	if ($method == "deletealbum"){
	require('../includes/dbdelete.php');
	$update = deleteAlbum($editId);
	echo " <i class=\"fa fa-check\" style='font-size: 1.2em; color: red;' ></i> $update";
	}
} // end method check (album edit/deletes)

// consolidate artist / create golden artist
if (isset($_POST['consolidate'])) {
	// print_r($_POST);
	// echo "con";
	require('includes/dbupdate.php');

	$goldenArtistId = $_POST['newId']; // artist what will be golden
	$artistId = $_POST['artistId']; // current artist id
	$artistName = $_POST['aa'];

	$update = consolidateArtist($artistId, $goldenArtistId, $artistName);
		echo " <i class=\"fa fa-check\" style='font-size: 1.2em; color: green;' ></i>";

}

// reassign artist 
if (isset($_POST['reassign'])) {
	// print_r($_POST);
	// echo "ass";
	require('includes/dbupdate.php');
	$albumartist = $_POST['albumArtist'];
	$newArtistId = $_POST['newId']; // new artist id
	$itemId = $_POST['itemId']; // album or track id
	$mode = $_POST['mode']; // reassign mode

	if ($mode == "track") {
	$update = updateTrackArtist($newArtistId, $itemId);
		echo " <i class=\"fa fa-check\" style='font-size: 1.2em; color: green;' ></i>";
	}

	if ($mode == "album") {
	$update1 = updateAlbumArtistId($newArtistId, $itemId);
	$update2 = updateAlbumArtistName($albumartist, $itemId);

		echo " <i class=\"fa fa-check\" style='font-size: 1.2em; color: green;' ></i>";
	}

}
// echo $_POST['trackTitle'] . " " . $_POST['trackId'];
?>