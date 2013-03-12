<?php

class V1 extends API {
	
	public function store_last_checkin() {
		
		$checkin = json_decode($_POST['checkin'], true);

		$results['code'] = 1;
		$results['message'] = 'Success';
		
		$lat = $checkin['venue']['location']['lat'];
		$lng = $checkin['venue']['location']['lng'];
		
		$results['lat'] = $lat;
		$results['lng'] = $lng;
		
		$settingsModel = $this->getModel('Settings');
		
		$settingsModel->setValue('last_checkin_lat', $lat);
		$settingsModel->setValue('last_checkin_lng', $lng);
		
		print(json_encode($results));
		die();
	}
	
	
}
