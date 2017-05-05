<?php
	$token = getenv('DISCOGS_TOKEN');
	// $tarts = "miracles";
	    $data = array();
    $data_row = array();
	$terms = $_GET['term'];
	$term = explode(' - ', $terms);
	$tiats = $term[1];
	$tarts = $term[0];

    // $searchTerm = "paul";
	$tarts = urlencode($tarts);
	$tiats = urlencode($tiats);
	$url = "https://api.discogs.com/database/search?artist=\"$tarts\"&title=\"$tiats\"&token=$token&per_page=15";

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
	$res = $results->results;
	foreach ($res as $r) {
	// echo "<pre>";
	// var_dump($r);
	// echo "</pre>";
	$artisttitle = $r->title."(".$r->format[0].")";
	// $format = $r->format[0];
	$resid = $r->id; 
		// echo " <a href='".$r->resource_url."'>".$r->title." (".$r->format[0].")<br>";
	        $data_row["id"] = $resid;
        $data_row["value"] = $artisttitle;
        array_push($data,$data_row);
	}
	    echo json_encode($data);
?>