<?php

class PagesController extends Controller {
	
	var $models = array('Activitys', 'Teams');
	
	public function index() {
		$activityModel = new ActivitysModel();
		
		$activitys = $activityModel->getActivitys();
		
		$this->setVar('activitys', $activitys);
		
		$teamModel = new TeamsModel();
		
		$teams = $teamModel->select();
		
		$this->setVar('teams', $teams);
	}	
}
