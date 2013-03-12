<?php

class FourSquare {
	
	private $clientId;
	private $clientSectret;
	private $redirectURI;
	
	public function __construct() {
		$this->clientId = 'FVDTO5P1LZGWOTK1Z1OOMRJ2RUGQJLEA2G2E1CHSV04KEXER';
		$this->clientSectret = 'NL4MA0MXXYMSGRNHMEBPQ0JAAGAOHR0R25BXKFF0MLWRKXB0';
		$this->redirectURI = 'http://' . $_SERVER['SERVER_NAME'] . '/cs462/store/users/auth_foursquare';
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
