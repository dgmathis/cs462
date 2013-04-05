<?php

class DriversController extends Controller {
	
	var $models = array('Drivers');
	
	public function index() {

		$driversModel = new DriversModel();
		
		$drivers = $driversModel->select();
		
		$this->setVar('drivers', $drivers);
	}
	
	public function before() {
		
	}
	
	public function add() {
		if(!empty($_POST)) {
			// Add a new driver
			$data['guid'] = $_POST['guid'];
			$data['esl'] = $_POST['esl'];
			
			$driverModel = new DriversModel();
			
			$result = $driverModel->addDriver($data);
			
			if($result['code'] == 0) {
				Core::setFlash($result['message']);
			}
			
			$driver = $driverModel->select(array(
				'Conditions' => "guid = '" . $data['guid'] . "'",
				'Limit' => 1
			));
			
			header('location: ' . ROOT . DS . 'drivers');
			exit();
		}
	}
	
	public function edit($id) {

		if(!empty($_POST)) {
			$driver['id'] = $id;
			$driver['guid'] = $_POST['guid'];
			$driver['esl'] = $_POST['esl'];
			
			$driverModel = new DriversModel();
			
			$result = $driverModel->updateDriver($driver);
			
			Core::setFlash($result['message']);
			
			if($result['code'] == 1) {
				header('location: ' . ROOT . DS . 'drivers' . DS . view . DS . $id);
				die();
			}
			
			$this->setVar('driver', $driver);
		} else {
			$driverModel = new DriversModel();
			
			$driverData = $driverModel->select(array(
				'Conditions' => "id = '$id'",
				'Limit' => 1
			));
			
			if(empty($driverData)) {
				Core::setFlash('Sorry, but that driver does not exist');
				header('location: ' . ROOT . DS . 'drivers');
				die();
			}
			
			$this->setVar('driver', $driverData[0]);
		}
	}
	
	public function view($id) {
		if(empty($id)){
			die('Please provide an id for the driver.');
		}

		$driverModel = new DriversModel();

		$driver = $driverModel->select(array(
			'Conditions' => "id = '$id'",
			'Limit' => 1
		));

		if(empty($driver) || empty($driver[0])){
			die('Could not find that driver');
		}

		$this->setVar('driver', $driver[0]);
	}
	
	public function delete($id) {
		if(!empty($id)) {
			$driverModel = new DriversModel();
			$driverModel->delete($id);
		}
		
		header("Location: " . ROOT . DS . 'drivers');
		die();
	}
}
