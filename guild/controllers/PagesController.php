<?php

class PagesController extends Controller {
	
	var $models = array('Stores', 'Drivers');
	
	public function index() {
		$storesModel = new StoresModel();
		
		$stores = $storesModel->select();
		
		$driversModel = new DriversModel();
		
		$drivers = $driversModel->select();
		
		$this->setVar('stores', $stores);
		$this->setVar('drivers', $drivers);
	}	
}
