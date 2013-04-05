<?php

class StoresController extends Controller {
	
	var $models = array('Stores');
	
	public function index() {
		$storesModel = new StoresModel();
		
		$stores = $storesModel->select();
		
		$this->setVar('stores', $stores);
	}
	
	public function add() {
		if(!empty($_POST)) {
			// Add a new user
			$data['name'] = $_POST['name'];
			$data['lat'] = $_POST['lat'];
			$data['lng'] = $_POST['lng'];
			$data['esl'] = $_POST['esl'];
			
			$storesModel = new StoresModel();
			
			$result = $storesModel->insert($data);
			
			if($result == '1') {
				header('Location: ' . ROOT . DS . 'stores');
			}
			
			Core::setFlash("Failed to add store");
			$this->setVar('data', $data);
		}
	}
	
	public function edit($id) {

		$storesModel = new StoresModel();
		
		if(!empty($_POST)) {
			$store['id'] = $id;
			$store['name'] = $_POST['name'];
			$store['lat'] = $_POST['lat'];
			$store['lng'] = $_POST['lng'];
			$store['esl'] = $_POST['esl'];
			
			if($storesModel->update($store)) {
				header('location: ' . ROOT . DS . 'stores' . DS . view . DS . $id);
				die();
			}
			
			$this->setVar('store', $store);
		} else {

			$storeData = $storesModel->select(array(
				'Conditions' => "id = '$id'",
				'Limit' => 1
			));
			
			if(empty($storeData)) {
				Core::setFlash('Sorry, but that driver does not exist');
				header('location: ' . ROOT . DS . 'users');
				die();
			}
			
			$this->setVar('store', $storeData[0]);
		}
	}
	
	public function view($id) {
		if(empty($id)) {
			Core::setFlash("Sorry, but that store doesn't exist");
			header('Location: ' . ROOT . DS . 'stores');
			die();
		}
		
		$storesModel = new StoresModel();
		$storeData = $storesModel->select(array(
			'Conditions' => "id = '$id'",
			'Limit' => 1
		));
		
		if(empty($storeData)) {
			Core::setFlash("Sorry, but that store doesn't exist");
			header('Location: ' . ROOT . DS . 'stores');
			die();
		}
		
		$this->setVar('store', $storeData[0]);
	}
	
	public function delete($id) {
		if(!empty($id)) {
			$storesModel = new StoresModel();
			$storesModel->delete($id);
		}
		
		header("Location: " . ROOT . DS . 'stores');
		die();
	}
}
