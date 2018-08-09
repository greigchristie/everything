<?php
// SEARCH query functions

function searchKeyword($keyword) {
include('connected.php');


/* create a prepared statement */
if ($stmt = $con->prepare("SELECT artists.artist_name, artists.id as artist_id, tracks.track_title, albums.album_title, albums.album_artist_name, albums.album_collection, albums.id as album_id, albums.album_artist_id FROM artists,albums,tracks WHERE artists.id = tracks.track_artist_id and albums.id = tracks.album_id and tracks.track_owned=1 and (tracks.track_title like concat('%',?,'%') or albums.album_title like concat('%',?,'%') or artists.artist_name like concat('%',?,'%'))")) {

    /* bind parameters for markers */
    $stmt->bind_param("sss", $keyword,$keyword,$keyword);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

    return($result);
    
    /* close statement */
    $stmt->close();
    

}

/* close connection */
$con->close();
}

function searchAlbumArtist($searchterm){
include('connected.php');


/* create a prepared statement */
if ($stmt = $con->prepare("SELECT albums.album_title, albums.album_artist_name, albums.album_collection, albums.id as album_id, albums.album_artist_id FROM albums WHERE  albums.album_artist_name like concat('%',?,'%')")) {

    /* bind parameters for markers */
    $stmt->bind_param("s", $searchterm);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

	    return($result);
    /* close statement */
    $stmt->close();
    

}

/* close connection */
$con->close();
}

function searchCollection($searchterm){
include('connected.php');


/* create a prepared statement */
if ($stmt = $con->prepare("SELECT albums.album_title, albums.album_artist_name, albums.album_collection, albums.id as album_id, albums.album_artist_id FROM albums WHERE  albums.album_collection like concat('%',?,'%')")) {

    /* bind parameters for markers */
    $stmt->bind_param("s", $searchterm);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

	    return($result);
    /* close statement */
    $stmt->close();
    

}

/* close connection */
$con->close();
}

function searchTrackArtist($searchterm){
include('connected.php');


/* create a prepared statement */
if ($stmt = $con->prepare("SELECT artists.artist_name, artists.id as artist_id, tracks.track_title, albums.album_title, albums.album_artist_name, albums.album_collection, albums.id as album_id, albums.album_artist_id FROM artists,albums,tracks WHERE artists.id = tracks.track_artist_id and albums.id = tracks.album_id and tracks.track_owned=1 and artists.artist_name like concat('%',?,'%')")) {

    /* bind parameters for markers */
    $stmt->bind_param("s", $searchterm);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

	    return($result);
    /* close statement */
    $stmt->close();
    

}

/* close connection */
$con->close();
}

// search for tracks where search artist id matches passed value
function searchArtistId($searchterm){
include('connected.php');

/* create a prepared statement */
if ($stmt = $con->prepare("SELECT artists.artist_name, artists.id as artist_id, artists.artist_alt_id, tracks.track_title, albums.album_title, albums.album_artist_name, albums.album_collection, albums.id as album_id, albums.album_artist_id FROM artists,albums,tracks WHERE artists.id = tracks.track_artist_id and albums.id = tracks.album_id and tracks.track_owned=1 and artists.id = ?")) {

    /* bind parameters for markers */
    $stmt->bind_param("i", $searchterm);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

	    return($result);
    /* close statement */
    $stmt->close();
    

}
}

function getArtistDetailsId($artistid) {
include('connected.php');

/* create a prepared statement */
if ($stmt = $con->prepare("SELECT * from artists where id = ?")) {

    /* bind parameters for markers */
    $stmt->bind_param("i", $artistid);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

	    return($result);
    /* close statement */
    $stmt->close();
}

/* close connection */
$con->close();
}

function searchAlbumTitle($searchterm){
include('connected.php');


/* create a prepared statement */
if ($stmt = $con->prepare("SELECT artists.artist_name, artists.id as artist_id, tracks.track_title, albums.album_title, albums.album_artist_name, albums.album_collection, albums.id as album_id, albums.album_artist_id FROM artists,albums,tracks WHERE artists.id = tracks.track_artist_id and albums.id = tracks.album_id and tracks.track_owned=1 and albums.album_title like concat('%',?,'%')")) {

    /* bind parameters for markers */
    $stmt->bind_param("s", $searchterm);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

	    return($result);
    /* close statement */
    $stmt->close();
    

}

/* close connection */
$con->close();
}

function searchAlbumId($searchterm){
include('connected.php');


/* create a prepared statement */
if ($stmt = $con->prepare("SELECT artists.artist_name, artists.id as artist_id, tracks.track_title, tracks.track_order, albums.album_title, albums.album_artist_name, albums.album_collection, albums.id as album_id, albums.album_artist_id FROM artists,albums,tracks WHERE artists.id = tracks.track_artist_id and albums.id = tracks.album_id and tracks.track_owned=1 and albums.id = ?")) {

    /* bind parameters for markers */
    $stmt->bind_param("s", $searchterm);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

	    return($result);
    /* close statement */
    $stmt->close();
    

}

/* close connection */
$con->close();
}

function searchTrackTitle($searchterm){
include('connected.php');


/* create a prepared statement */
if ($stmt = $con->prepare("SELECT artists.artist_name, artists.id as artist_id, tracks.track_title, albums.album_title, albums.album_artist_name, albums.album_collection, albums.id as album_id, albums.album_artist_id FROM artists,albums,tracks WHERE artists.id = tracks.track_artist_id and albums.id = tracks.album_id and tracks.track_owned=1 and track_title like concat('%',?,'%')")) {

    /* bind parameters for markers */
    $stmt->bind_param("s", $searchterm);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

	    return($result);
    /* close statement */
    $stmt->close();
    

}

/* close connection */
$con->close();
}

/* General SELECTS */

/* Album select */

function getAlbums() {
include ('connected.php');


/* create a prepared statement */
if ($stmt = $con->prepare("SELECT * FROM albums where album_owned = 1 ORDER by album_sort_title"));

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

	    return($result);
    /* close statement */
    $stmt->close();
}

/* get album information by albumid */

function getAlbumsById($albumid) {
include ('connected.php');


/* create a prepared statement */
if ($stmt = $con->prepare("SELECT * FROM albums where id = ? and album_owned = 1 ORDER by album_sort_title"));

    /* bind parameters for markers */
    $stmt->bind_param("i", $albumid);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

        return($result);
    /* close statement */
    $stmt->close();
}

/* get album information by albumid & collection */

function getAlbumsByArtistIdCollection($artistid,$albumcollection) {
include ('connected.php');


/* create a prepared statement */
if ($stmt = $con->prepare("SELECT * FROM albums where album_artist_id = ? and album_collection = ? and album_owned = 1"));

    /* bind parameters for markers */
    $stmt->bind_param("is", $artistid, $albumcollection);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

        return($result);
    /* close statement */
    $stmt->close();
}

/* Album select (paginated) */

function getAlbumsPaginated($offset,$bottom) {
include ('connected.php');

/* create a prepared statement */
if ($stmt = $con->prepare("SELECT album_title, id, album_artist_name, album_artist_id, album_collection FROM albums where album_owned = 1 ORDER by album_sort_title LIMIT ? OFFSET ?"));

    /* bind parameters for markers */
    $stmt->bind_param("ii", $offset, $bottom);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

	    return($result);
    /* close statement */
    $stmt->close();
}


function getRecentAlbumsPaginated($offset,$bottom) {
include ('connected.php');

/* create a prepared statement */
if ($stmt = $con->prepare("SELECT album_title, id, album_artist_name, album_artist_id, album_collection FROM albums where album_owned = 1 ORDER by id desc LIMIT ? OFFSET ?"));

    /* bind parameters for markers */
    $stmt->bind_param("ii", $offset, $bottom);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

        return($result);
    /* close statement */
    $stmt->close();
}


function getTracksForAlbum($albumid) {
include('connected.php');
/* create a prepared statement */
if ($stmt = $con->prepare("SELECT * from tracks where album_id = ?")) {

    /* bind parameters for markers */
    $stmt->bind_param("i", $albumid);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

        return($result);
    /* close statement */
    $stmt->close();
    }

/* close connection */
$con->close();

}

function getAlbumCollectionforAlbumArtist($artistid) {
    include('connected.php');
    $dlibrary = "dlibrary";
    $itunes = "itunes";
    $vinyl = "vinyl";
    $cdsingle = "cdsingle";
    $coverdisc = "coverdisc";
/* create a prepared statement */
if ($stmt = $con->prepare("SELECT album_collection from albums where album_artist_id = ? group by album_collection order by field(album_collection,?,?,?,?,?)")) {

    /* bind parameters for markers */
    $stmt->bind_param("isssss", $artistid,$dlibrary,$itunes,$vinyl,$cdsingle,$coverdisc);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

        return($result);
    /* close statement */
    $stmt->close();
    }

/* close connection */
$con->close();

}

function getAlbumsByTrackArtistNotAlbumArtist($artistid) {
    include('connected.php');

/* create a prepared statement */
if ($stmt = $con->prepare("SELECT albums.id, albums.album_title, albums.album_collection from albums, tracks where albums.id = tracks.album_id and tracks.track_artist_id = ? and albums.album_artist_id <> ? group by albums.id order by albums.id")) {

    /* bind parameters for markers */
    $stmt->bind_param("ii", $artistid, $artistid);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

        return($result);
    /* close statement */
    $stmt->close();
    }

/* close connection */
$con->close();
}

function getalbumArtists() {
	include('connected.php');
	/* create a prepared statement */
	if ($stmt = $con->prepare("SELECT distinct(album_artist_id) FROM albums"));

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

	    return($result);
    /* close statement */
    $stmt->close();
}

function getalbumArtistsPaginated($offset,$bottom) {
	include('connected.php');
/* create a prepared statement */
if ($stmt = $con->prepare("SELECT artists.id as artist_id, artists.artist_name FROM artists, albums where artists.id = albums.album_artist_id and album_owned = 1 group by artists.id ORDER by artists.artist_sort_name LIMIT ? OFFSET ?"));

    /* bind parameters for markers */
    $stmt->bind_param("ii", $offset, $bottom);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

        return($result);
    /* close statement */
    $stmt->close();
}

function getTracks() {
include ('connected.php');


/* create a prepared statement */
if ($stmt = $con->prepare("SELECT * from tracks where track_owned = 1"));

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

        return($result);
    /* close statement */
    $stmt->close();
}

function getTracksPaginated($offset,$bottom) {
include ('connected.php');


/* create a prepared statement */
if ($stmt = $con->prepare("SELECT artists.artist_name, tracks.track_title, albums.album_title, albums.id as 'album_id', albums.album_artist_id, artists.id as 'artist_id', albums.album_collection FROM albums, artists, tracks where artists.id = tracks.track_artist_id and albums.id = tracks.album_id and tracks.track_owned = 1 ORDER by tracks.track_sort_title LIMIT ? OFFSET ?"));

    /* bind parameters for markers */
    $stmt->bind_param("ii", $offset, $bottom);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

        return($result);
    /* close statement */
    $stmt->close();
}



function getTracksNotAlbumArtistId($artistid){
include('connected.php');


/* create a prepared statement */
if ($stmt = $con->prepare("SELECT artists.artist_name, artists.id as artist_id, tracks.track_title, albums.album_title, albums.album_artist_name, albums.album_collection, albums.id as album_id, albums.album_artist_id FROM artists,albums,tracks WHERE artists.id = tracks.track_artist_id and albums.id = tracks.album_id and tracks.track_owned=1 and tracks.track_artist_id = ? and albums.album_artist_id <> ?")) {

    /* bind parameters for markers */
    $stmt->bind_param("ii", $artistid, $artistid);

    /* execute query */
    $stmt->execute();

    /* instead of bind_result: */
    $result = $stmt->get_result();

        return($result);
    /* close statement */
    $stmt->close();
    }

/* close connection */
$con->close();
}
?>