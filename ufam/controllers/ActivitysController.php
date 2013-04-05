<?php

class ActivitysController extends Controller {
	var $models = array('Activitys', 'Teams', 'ActivitysTeams');
	
	public function index() {
		
		$activitys = $this->getActivitys();
		
		$this->setVar('activitys', $activitys);
	}
	
	private function getActivitys() {
		$activitysModel = new ActivitysModel();
		$teamsModel = new TeamsModel();
		
		$activitys = $activitysModel->select();
		
		$len = count($activitys);
		
		for($i = 0; $i < $len; $i++) {
			$teams = $teamsModel->getTeamsByActivity($activitys[$i]['id']);
			$activitys[$i]['hasJoined'] = (empty($teams)) ? false : true;
		}
		
		return $activitys;
	}
	
	public function add() {
		if(!empty($_POST)) {
			$data['title'] = $_POST['title'];
			$data['date'] = $_POST['date'];
			$data['location'] = $_POST['location'];
			$data['description'] = $_POST['description'];
			
			$activityModel = new ActivitysModel();
			
			$result = $activityModel->addActivity($data);
			
			if($result['code'] == 0) {
				Core::setFlash($result['message']);
			}
			
			header('location: ' . ROOT . DS . 'activitys');
			exit();
		}
	}
	
	public function edit($id) {

		if(!empty($_POST)) {
			$data['id'] = $id;
			$data['title'] = $_POST['title'];
			$data['date'] = $_POST['date'];
			$data['location'] = $_POST['location'];
			$data['description'] = $_POST['description'];
			
			$activityModel = new ActivitysModel();
			
			$result = $activityModel->updateActivity($data);
			
			Core::setFlash($result['message']);
			
			if($result['code'] == 1) {
				header('location: ' . ROOT . DS . 'activitys' . DS . view . DS . $id);
				die();
			}
			
			$this->setVar('activity', $data);
			
		} else {
			
			$activityModel = new ActivitysModel();
			
			$activityData = $activityModel->select(array(
				'Conditions' => "id = '$id'",
				'Limit' => 1
			));
			
			if(empty($activityData)) {
				Core::setFlash('Sorry, but that activity does not exist');
				header('location: ' . ROOT . DS . 'activitys');
				die();
			}
			
			$this->setVar('activity', $activityData[0]);
		}
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
			header("Location: " . ROOT . DS . 'activitys');
			die();
		}
		
		$activitysTeamsModel = new ActivitysTeamsModel();
		
		if(!$activitysTeamsModel->unjoinActivity($activityId, $teamId)) {
			Core::setFlash("Failed to unjoin that activity");
			header("Location: " . ROOT . DS . 'activitys');
			die();
		}
		
		Core::setFlash("You successfully unjoined that activity");
		header("Location: " . ROOT . DS . 'activitys');
		die();
	}
	
	public function join($activityId) {
		$teamId = $_SESSION['team']['id'];
		
		if(empty($teamId)) {
			Core::setFlash("You cannot join that activity");
			header("Location: " . ROOT . DS . 'activitys');
			die();
		}
		
		$activitysTeamsModel = new ActivitysTeamsModel();
		
		if(!$activitysTeamsModel->joinActivity($activityId, $teamId)) {
			Core::setFlash("Failed to join that activity");
			header("Location: " . ROOT . DS . 'activitys');
			die();
		}
		
		Core::setFlash("You successfully joined that activity");
		header("Location: " . ROOT . DS . 'activitys');
		die();
	}
}