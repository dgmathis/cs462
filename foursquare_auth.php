<?php

$redirectURI = 'http://' . $_SERVER['SERVER_NAME'] . '/foursquare_auth.php';

if(!isset($_REQUEST['code'])) {
	$url = "https://foursquare.com/oauth2/authenticate?client_id=4O3BSLAVZKDU5EGZDNH22OOYPXOIUOTPOAKZBJS40RUIOOAV&response_type=code&redirect_uri=$redirectURI";

	header("location: $url");
	exit();
} else {
	$code = $_REQUEST['code'];
	$url = "https://foursquare.com/oauth2/access_token?client_id=4O3BSLAVZKDU5EGZDNH22OOYPXOIUOTPOAKZBJS40RUIOOAV&client_secret=JT2EKNDC0HB3JWQWCOIURDR42JYQMOJHGITKPHHCMQZUPRYL&grant_type=authorization_code&redirect_uri=$redirectURI&code=$code";

	// Get the access_token for foursquare

	$result = file_get_contents($url);

	$result = json_decode($result, true);

	$accessToken = $result['access_token'];

	// Get the user data from foursquare
	/*
	$url = "https://api.foursquare.com/v2/users/self?oauth_token=$accessToken&v=20130101";

	$result = file_get_contents($url);

	$result = json_decode($result, true);

	print_r($result['response']['user']);
	*/

	// Save user to file

	$filename = '/tmp/userdata.json';

	echo "\n" . filesize($filename) . "\n";

	// Open a file
	$fhandle = fopen($filename, 'r+');
	// Get the contents of the file
	$fcontent = fread($fhandle, filesize($filename));

	echo "Content: $fcontent\n";

	// Get the user data
	$userData = json_decode($fcontent, true);

	print_r($userData);

	if(empty($userData)) {
		$userData = array();
	}

	$userData[] = $accessToken;

	fwrite($fhandle, json_encode($userData));

	fclose($fhandle);

	exit();
}
