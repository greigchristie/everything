<?php
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    // last request was more than 60 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
    session_start(); // restart the session??
} else {
if (!isset($_SESSION['SP_TOKEN'])) { // if the spotify token isn't set go and get it
$_SESSION['LAST_ACTIVITY'] = time();
$client_id = getenv('SPOTIFY_CLIENT');
$client_secret = getenv('SPOTIFY_SECRET');
$clients = $client_id.":".$client_secret;
$clientsenc = base64_encode($clients);
//$postfields = array();
//$postfields['grant_type'] = "client_credentials";
$postfields = "grant_type=client_credentials";


    $url = 'https://accounts.spotify.com/api/token';
    $method = 'POST';


    $credentials = $clients;

    $headers = array(
            "Accept: */*",
            "Content-Type: application/x-www-form-urlencoded",
            "User-Agent: everything/1.0",
            "Authorization: Basic " . base64_encode($credentials));




        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
//        print_r($response);

$_SESSION['SP_TOKEN'] = $response["access_token"]; //assign token to session variable
//echo "<h3>$sp_token</h3>";

}
}
?>