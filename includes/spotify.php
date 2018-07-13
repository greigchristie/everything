<?php

function spotifyIdCover($albumTitle, $albumArtist) {
			include('spauth.php');
			// echo $albumTitle . " - " . $albumArtist;
			$ualbumtitle = urlencode($albumTitle);
			$ualbumartist = urlencode($albumArtist);
			$coverimage = "";

			$url = "https://api.spotify.com/v1/search?q=album%3A$ualbumtitle+artist%3A$ualbumartist&type=album&market=gb&limit=5";
			$headers = array("Authorization: Bearer " . $_SESSION['SP_TOKEN']);

			       // echo "service url<pre>";
			       // echo $url."<br />";
			       // echo "</pre>";
			//  Initiate curl
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// Will return the response, if false it print the response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'everything/1.0 +http://grey-boxes.com/everything');
			// Set the url
			curl_setopt($ch, CURLOPT_URL,$url);
			// Execute
			$result=curl_exec($ch);
			// Closing
			curl_close($ch);
			// echo "<pre>";
			// print_r($result);
			// echo "</pre>";
			$results = json_decode($result);
			

		// Will dump a beauty json :3
		
		//  echo "<pre>";
		//  print_r($results);
		//  echo "</pre>";
		// echo "<p>$available</p>";
		$coverimage = "";
		$spotifyuri = $results->albums->items;
		if (count($spotifyuri) > 0) {
		$spotifyuri = $results->albums->items[0]->uri;
		} else {
		$spotifyuri = "";
		}
		if ($spotifyuri != "") {
		$coverimage = $results->albums->items[0]->images[1]->url;
		}
		//echo $spotifyuri;
		$spotifyIdCover = $spotifyuri . " - " . $coverimage;
		return $spotifyIdCover;
}

function spotifyArtist($artistName) {
		// echo $artistName;
		include('spauth.php');
		$uartist = urlencode($artistName);
//echo $getartist;



			$url ="https://api.spotify.com/v1/search?q=$uartist&type=artist&market=gb&limit=5";
			$headers = array("Authorization: Bearer " . $_SESSION['SP_TOKEN']);

			       // echo "service url<pre>";
			       // echo $url."<br />";
			       // echo "</pre>";
			//  Initiate curl
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// Will return the response, if false it print the response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'everything/2.0 +http://every-thing.co.uk');
			// Set the url
			curl_setopt($ch, CURLOPT_URL,$url);
			// Execute
			$result=curl_exec($ch);
			// Closing
			curl_close($ch);
			// echo "<pre>";
			// print_r($result);
			// echo "</pre>";
			$results = json_decode($result);
			
		$spotifyuri = $results->artists->items;
		// $spotifyuri = "";
		if (count($spotifyuri) > 0) {
		$spotifyuri = $results->artists->items[0]->uri;
		} else {
		$spotifyuri = "";
		}
		$coverimage = "";
		$artistSpotName = "";
		if ($spotifyuri != "") {
			// echo "<pre>";
			// print_r($results->artists);
			// echo "</pre>";
		$coverimage = $results->artists->items[0]->images[1]->url;		
		$artistSpotName = $results->artists->items[0]->name;
		}

		$spotifyArtistName = $coverimage . " - " . $artistSpotName . " - " . $spotifyuri;
		return $spotifyArtistName;
}
?>