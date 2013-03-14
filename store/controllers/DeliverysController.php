<?php

class DeliverysController extends Controller {
	
	var $models = array('Deliverys', 'Bids');
	var $layout = 'admin';
	
	public function before() {
		if(empty($_SESSION['admin']) && $_SERVER['REQUEST_URI'] != ROOT . '/admin/login') {
			header("location: " . ROOT . "/admin/login");
		}
	}
	
	public function view($id) {
		$bidsModel = new BidsModel();
		
		$bids = $bidsModel->select(array(
			'Conditions' => "delivery_id = '$id'"
		));
		
		$this->setVar('bids', $bids);
	}
}
