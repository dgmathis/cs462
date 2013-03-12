<?php

class SettingsController extends Controller {
	
	var $models = array('Settings');
	
	public function auth_foursquare() {
		include 'tools' . DS . 'FourSquare.php';
		
		$fourSquare = new FourSquare();
		
		if(!isset($_REQUEST['code'])) {
			$fourSquare->requestCode();
		} else {
			
			$code = $_REQUEST['code'];
			$accessToken = $fourSquare->getAccessToken($code);

			$settingsModel = new SettingsModel();
			
			$settingsModel->setValue('fs_access_token', $accessToken);
			
			header('location: ' . ROOT);
		}
	}
	
}