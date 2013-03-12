<?php

class PagesController extends Controller {
	
	var $models = array('Settings');
	
	public function index() {
		$settingsModel = new SettingsModel();
		
		$username = $settingsModel->getValue('username');
		
		if(empty($username)) {
			Core::setFlash("You must have an account to use this site");
			header('Location: ' . ROOT . DS . 'create_account');
		}
		
		print("INDEX"); 
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
