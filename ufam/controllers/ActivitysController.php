<?php

class ActivitysController extends Controller {
	var $models = array('Activitys', 'Teams', 'ActivitysTeams');
	
	public function index() {
		
		$activityModel = new ActivitysModel();
		
		$activitys = $activityModel->getActivitys();
		
		$this->setVar('activitys', $activitys);
	}
	
	public function add() {
		if(empty($_SESSION['team'])) {
			Core::setFlash("Please log in to create an activity");
			Core::redirect();
		}
		
		if(!empty($_POST)) {
			$activityData['title'] = $_POST['title'];
			$activityData['date'] = $_POST['date'];
			$activityData['location'] = $_POST['location'];
			$activityData['description'] = $_POST['description'];
			$activityData['owner_team_id'] = $_SESSION['team']['id'];
			
			$activityModel = new ActivitysModel();
			
			$result = $activityModel->addActivity($activityData);
			
			if($result['code'] == 0) {
				Core::setFlash($result['message']);
			}
			
			$activitysTeamsModel = new ActivitysTeamsModel();
			
			$activityTeamData['team_id'] = $_SESSION['team']['id'];
			$activityTeamData['activity_id'] = $activityModel->getLastInsertId();
			
			$result = $activitysTeamsModel->insert($activityTeamData);
			
			if(!$result) {
				Core::setFlash('Failed to join team to activity');
			}
			
			header('location: ' . ROOT . DS . 'activitys');
			exit();
		}
	}
	
	public function edit($id) {
		
		$activityModel = new ActivitysModel();
		
		$activity = $activityModel->select(array(
			'Conditions' => "id = '$id'",
			'Limit' => 1
		));
		
		if(empty($activity)) {
			Core::setFlash('Sorry, but that activity does not exist');
			header('location: ' . ROOT . DS . 'activitys');
			die();
		}
		
		$activity = $activity[0];
		
		if(empty($_SESSION['team']) || $_SESSION['team']['id'] != $activity['owner_team_id']) {
			Core::setFlash('You do not have permission to edit that activity');
			header('location: ' . ROOT . DS . 'activitys');
			die();
		}
		
		if(!empty($_POST)) {
			$data['id'] = $id;
			$data['title'] = $_POST['title'];
			$data['date'] = $_POST['date'];
			$data['location'] = $_POST['location'];
			$data['description'] = $_POST['description'];
			
			$result = $activityModel->updateActivity($data);
			
			Core::setFlash($result['message']);
			
			if($result['code'] == 1) {
				header('location: ' . ROOT . DS . 'activitys' . DS . view . DS . $id);
				die();
			}
			
			$activity = $data;
		}
		
		$this->setVar('activity', $activity);
	}
	
	public function view($id) {
		if(empty($id)){
			die('Please provide an id for the activity.');
		}

		$activityModel = new ActivitysModel();

		$activity = $activityModel->select(array(
			'Conditions' => "id = '$id'",
			'Limit' => 1
		));

		if(empty($activity) || empty($activity[0])){
			die('Could not find that activity');
		}

		$teamsModel = new TeamsModel();
		$teams = $teamsModel->getTeamsByActivity($id);
		
		$this->setVar('activity', $activity[0]);
		$this->setVar('teams', $teams);
	}
	
	public function delete($id) {
		if(!empty($id)) {
			$activityModel = new ActivitysModel();
			$activityModel->delete($id);
		}
		
		header("Location: " . ROOT . DS . 'activitys');
		die();
	}
	
	public function unjoin($activityId) {
		$teamId = $_SESSION['team']['id'];
		
		if(empty($teamId)) {
			Core::setFlash("You cannot unjoin that activity");
			Core::redirect();
		}
		
		$activitysTeamsModel = new ActivitysTeamsModel();
		
		if(!$activitysTeamsModel->unjoinActivity($activityId, $teamId)) {
			Core::setFlash("Failed to unjoin that activity");
			Core::redirect();
		}
		
		Core::setFlash("You successfully unjoined that activity");
		Core::redirect();
	}
	
	public function join($activityId) {
		$teamId = $_SESSION['team']['id'];
		
		if(empty($teamId)) {
			Core::setFlash("You cannot join that activity");
			Core::redirect();
		}
		
		$activitysTeamsModel = new ActivitysTeamsModel();
		
		if(!$activitysTeamsModel->joinActivity($activityId, $teamId)) {
			Core::setFlash("Failed to join that activity");
			Core::redirect();
		}
		
		Core::setFlash("You successfully joined that activity");
		Core::redirect();
	}
	
	public function forecast() {
		include 'tools' . DS . 'HAMWeather.php';
		
		$weather = HAMWeather::get_forecast('84058');
		
		$forecast = $weather['response'][0]['periods'];
		
		$activitysModel = new ActivitysModel();
		
		for($i = 0; $i < 7; $i++){
			$start = date('Y-m-d 00:00:00', $forecast[$i]['timestamp']);
			$end = date('Y-m-d 24:59:59', $forecast[$i]['timestamp']);
			$activitys = $activitysModel->select(array(
				'Conditions' => "date >= '$start' AND date <= '$end'"
			));
			
			$forecast[$i]['activities'] = array();
			
			foreach($activitys as $activity){
				$forecast[$i]['activities'][] = $activity;
			}
		}
		
		$this->setVar('forecast', $forecast);
	}
	
	public function notify_teams() {
	
	}
}