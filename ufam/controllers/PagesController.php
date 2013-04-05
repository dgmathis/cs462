<?php

class PagesController extends Controller {
	
	var $models = array('Activitys');
	
	public function index() {
		$activitysModel = new ActivitysModel();
		
		$activitys = $activitysModel->select();

		$this->setVar('activitys', $activitys);
	}	
}
