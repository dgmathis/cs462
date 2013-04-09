<?php

class HAMWeather {
	
	private static $clientId = '9zODOp7Fe0wtOwxMMGFou';
	private static $clientSecret = 'WWH19e6nQxmh4FiSamCz6rpAjQ2wNfaadPlqXzZK';
	
	public static function get_forecast($areaId) {
		$url = "http://api.aerisapi.com/forecasts/" . $areaId . "?client_id=" . self::$clientId . "&client_secret=" . self::$clientSecret;
		
		$result = file_get_contents($url);
		
		return json_decode($result, true);
	}
}
