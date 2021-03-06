<?php

class PagesController extends Controller {
	
	var $models = array('Settings', 'Deliverys');
	
	public function index() {
		$settingsModel = new SettingsModel();
		
		$username = $settingsModel->getValue('username');
		
		if(empty($username)) {
			Core::setFlash("You must have an account to use this site");
			header('Location: ' . ROOT . DS . 'pages' . DS . 'create_account');
		}
		
		$data['firstname'] = $settingsModel->getValue('firstname');
		$data['lastname'] = $settingsModel->getValue('lastname');
		$data['phonenumber'] = $settingsModel->getValue('driver_phone_number');
		$data['guid'] = $settingsModel->getValue('guid');
		
		$lastCheckin = $settingsModel->getValue('last_checkin');
		if(!empty($lastCheckin)) {
			$data['last_checkin'] = json_decode($lastCheckin, true);
		}
		
		$data['fs_access_token'] = $settingsModel->getValue('fs_access_token');
		
		$this->setVar('data', $data);
		
		$deliverysModel = new DeliverysModel();
		
		$deliverys = $deliverysModel->select();
		
		for($i = 0; $i < count($deliverys); $i++) {
			switch($deliverys[$i]['status']) {
				case 'available':
					$deliverys[$i]['class'] = 'warning';
					break;
				case 'Bid awarded':
					$deliverys[$i]['class'] = 'success';
					break;
			}
		}
		
		$this->setVar('deliverys', $deliverys);
	}
	
	public function update_phone() {
		if(!empty($_POST)) {
			$settingsModel = new SettingsModel();
			
			$phone = $_POST['phone_number'];
			
			if(!empty($phone)) {
				$phone = '+' . str_replace(array('-', ' '), '', $phone);
				
				$settingsModel->setValue('driver_phone_number', $phone);
				
				header('Location: ' . ROOT . DS);
			}
		}
	}
	
	public function gen_guid() {
		$settingsModel = new SettingsModel();
		
		$guid = uniqid('D_');
		
		$settingsModel->setValue('guid', $guid);
		
		header('Location: ' . ROOT . DS);
		die();
	}
	
	public function create_account() {
		if(!empty($_POST)) {
			// Add a new user
			$data['username'] = $_POST['username'];
			$data['password'] = $_POST['password'];
			$data['firstname'] = $_POST['firstname'];
			$data['lastname'] = $_POST['lastname'];
			
			$settingsModel = new SettingsModel();
			
			$saveData = true;
			
			foreach($data as $key => $value) {
				if(empty($value)) {
					$saveData = false;
					Core::setFlash("Please provide a " . $key);
				}
			}
			
			if($saveData == true) {
				$settingsModel->setValue('username', $data['username']);
				$settingsModel->setValue('password', $data['password']);
				$settingsModel->setValue('firstname', $data['firstname']);
				$settingsModel->setValue('lastname', $data['lastname']);
				
				header('Location: ' . ROOT);
			}
			
			$this->setVar('data', $data);
		}
	}
	
}
