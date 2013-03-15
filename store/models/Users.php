<?php

class UsersModel extends Model {
	
	public function addUser($user) {
		$id = $user['id'];
		
		$result = $this->validateUser($user);
		
		if($result['code'] == 0) {
			return $result;
		}
		
		$existing = $this->select(array(
			'Conditions' => "id = '$id'",
			'Limit' => 1
		));
		
		if(!empty($existing)) {
			return array('code' => 0, 'message' => 'Username is already taken.');
		}
		
		$user['password'] = Core::hash($user['password']);
		
		if(!$this->insert($user)) {
			return array('code' => 0, 'message' => 'Failed to add user.  Unknown reason');
		}
		
		return array('code' => 1, 'message' => 'Successfully added user.');
	}
	
	public function updateUser($user) {
		
		$result = $this->validateUser($user);
		
		if($result['code'] == 0) {
			return $result;
		}
		
		$user['password'] = Core::hash($user['password']);
		
		if(!$this->update($user)) {
			return array('code' => 0, 'message' => 'Failed to edit user.  Unknown reason');
		}
		
		return array('code' => 1, 'message' => 'Successfully edited user.');
		
	}
	
	public function validateUser($user) {
		if(empty($user['password'])) {
			return array('code' => 0, 'message' => 'Please provide a password.');
		}
		
		if(empty($user['username'])) {
			return array('code' => 0, 'message' => 'Please provide a username.');
		}
		
		if(empty($user['firstname'])) {
			return array('code' => 0, 'message' => 'Please provide a firstname.');
		}
		
		if(empty($user['lastname'])) {
			return array('code' => 0, 'message' => 'Please provide a lastname.');
		}
		
		return array('code' => 1);
	}
	
	public function getDrivers() {
		$drivers = $this->select(array(
			'Conditions' => "type = 'driver'"
		));
		
		return $drivers;
	}
}
