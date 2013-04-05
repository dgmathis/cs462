<?php

class DriversModel extends Model {
	
	public function addDriver($driver) {
		$guid = $driver['guid'];
		
		$result = $this->validateDriver($driver);
		
		if($result['code'] == 0) {
			return $result;
		}
		
		$existing = $this->select(array(
			'Conditions' => "guid = '$guid'",
			'Limit' => 1
		));
		
		if(!empty($existing)) {
			return array('code' => 0, 'message' => 'Driver globally unique id is already taken.');
		}
		
		// generate random rating for driver
		$driver['rating'] = (rand(0, 100) / 100);
		
		if(!$this->insert($driver)) {
			return array('code' => 0, 'message' => 'Failed to add driver.  Unknown reason');
		}
		
		return array('code' => 1, 'message' => 'Successfully added driver.');
	}
	
	public function updateDriver($driver) {
		
		$result = $this->validateDriver($driver);
		
		if($result['code'] == 0) {
			return $result;
		}

		if(!$this->update($driver)) {
			return array('code' => 0, 'message' => 'Failed to edit driver.  Unknown reason');
		}
		
		return array('code' => 1, 'message' => 'Successfully edited driver.');
		
	}
	
	public function validateDriver($driver) {
		if(empty($driver['guid'])) {
			return array('code' => 0, 'message' => 'Please provide a globally unique id.');
		}
		
		if(empty($driver['esl'])) {
			return array('code' => 0, 'message' => 'Please provide an ESL.');
		}
		
		return array('code' => 1);
	}
	
	public function getDrivers() {
		$drivers = $this->select(array(
			'Conditions' => "type = 'driver'"
		));
		
		return $drivers;
	}
	
	public function incrementDeliverysCompleted($driverGUID) {
		$driver = $this->getByField('guid', $driverGUID);
		
		if($driver === false) {
			return false;
		}
		
		$driver['deliverys_completed'] = intval($driver['deliverys_completed']) + 1;
		
		if(!$this->update($driver)) {
			return false;
		}
		
		return true;
	}
}
