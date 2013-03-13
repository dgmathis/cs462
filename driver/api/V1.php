<?php

class V1 extends API {
	
	public function store_last_checkin() {
		
		$checkin = json_decode($_POST['checkin'], true);

		error_log($_POST['checkin']);
		
		$results['code'] = 1;
		$results['message'] = 'Success';
		
		$checkinData['name'] = $checkin['venue']['name'];
		$checkinData['lat'] = $checkin['venue']['location']['lat'];
		$checkinData['lng'] = $checkin['venue']['location']['lng'];

		$settingsModel = $this->getModel('Settings');
		
		$settingsModel->setValue('last_checkin', json_encode($checkinData));

		print(json_encode($results));
		die();
	}
	
	
}
