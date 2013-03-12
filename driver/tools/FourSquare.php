<?php

class FourSquare {
	
	private $clientId;
	private $clientSectret;
	private $redirectURI;
	
	public function __construct() {
		$this->clientId = '4O3BSLAVZKDU5EGZDNH22OOYPXOIUOTPOAKZBJS40RUIOOAV';
		$this->clientSectret = 'JT2EKNDC0HB3JWQWCOIURDR42JYQMOJHGITKPHHCMQZUPRYL';
		$this->redirectURI = 'http://' . $_SERVER['SERVER_NAME'] . '/cs462/driver/settings/auth_foursquare';
	}
	
	public function requestCode() {
		$clientId = $this->clientId;
		$redirectURI = $this->redirectURI;
		
		$url = "https://foursquare.com/oauth2/authenticate?client_id=$clientId&response_type=code&redirect_uri=$redirectURI";
		header("location: $url");
		exit();
	}
	
	public function getAccessToken($code) {
		$clientId = $this->clientId;
		$clientSectret = $this->clientSectret;
		$redirectURI = $this->redirectURI;
		
		$url = "https://foursquare.com/oauth2/access_token?client_id=$clientId&client_secret=$clientSectret&grant_type=authorization_code&redirect_uri=$redirectURI&code=$code";

		// Get the access_token for foursquare

		$resultJSON = file_get_contents($url);

		$result = json_decode($resultJSON, true);

		$accessToken = $result['access_token'];
		
		return $accessToken;
	}
}
