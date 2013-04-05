<?php

class TeamsController extends Controller {
	
	var $models = array('Teams', 'Activitys');
	
	public function index() {

		$teamModel = new TeamsModel();
		
		$teams = $teamModel->select();
		
		$this->setVar('teams', $teams);
	}
	
	public function before() {
		
	}
	
	public function add() {
		if(!empty($_POST)) {
			// Add a new team
			$data['username'] = $_POST['username'];
			$data['password'] = $_POST['password'];
			$data['name'] = $_POST['name'];
			$data['esl'] = $_POST['esl'];
			
			$teamModel = new TeamsModel();
			
			$result = $teamModel->addTeam($data);
			
			if($result['code'] == 0) {
				Core::setFlash($result['message']);
			}
			
			$team = $teamModel->select(array(
				'Conditions' => "username = '" . $data['username'] . "'",
				'Limit' => 1
			));
			
			if(!empty($team) && !empty($team[0])) {
				$_SESSION['team'] = $team[0];
				
				$id = $team[0]['id'];
				header('location: ' . ROOT . DS . 'teams' . DS . 'view' . DS . $id);
				exit();
			}
			
			$this->setVar('data', $data);
		}
	}
	
	public function edit($id) {
		if(!isset($_SESSION['team']) || $_SESSION['team']['id'] != $id) {
			Core::setFlash('You do not have permission to edit that driver');
			header('location: ' . ROOT . DS . 'teams');
			die();
		}
		
		if(!empty($_POST)) {
			$team['id'] = $id;
			$team['username'] = $_POST['username'];
			$team['password'] = $_POST['password'];
			$team['name'] = $_POST['name'];
			$team['esl'] = $_POST['esl'];
			
			$teamModel = new TeamsModel();
			
			$result = $teamModel->updateTeam($team);
			
			Core::setFlash($result['message']);
			
			if($result['code'] == 1) {
				header('location: ' . ROOT . DS . 'teams' . DS . view . DS . $id);
				die();
			}
			
			$this->setVar('team', $team);
		} else {
			$teamModel = new TeamsModel();
			
			$teamData = $teamModel->select(array(
				'Conditions' => "id = '$id'",
				'Limit' => 1
			));
			
			if(empty($teamData)) {
				Core::setFlash('Sorry, but that driver does not exist');
				header('location: ' . ROOT . DS . 'teams');
				die();
			}
			
			$this->setVar('team', $teamData[0]);
		}
	}
	
	public function view($id) {
		if(empty($id)){
			die('Please provide an id for the team.');
		}

		$teamModel = new TeamsModel();

		$team = $teamModel->select(array(
			'Conditions' => "id = '$id'",
			'Limit' => 1
		));

		if(empty($team) || empty($team[0])){
			die('Could not find that team');
		}

		$activitysModel = new ActivitysModel();
		$activitys = $activitysModel->getActivitysByTeam($id);
		
		$this->setVar('team', $team[0]);
		$this->setVar('activitys', $activitys);
	}
	
	public function delete($id) {
		if(!empty($id)) {
			$teamModel = new TeamsModel();
			$teamModel->delete($id);
		}
		
		header("Location: " . ROOT . DS . 'teams');
		die();
	}
	
	public function login() {
		if(!empty($_POST)) {
			$username = $_POST['username'];
			$password = Core::hash($_POST['password']);
			
			$teamModel = new TeamsModel();
			
			$team = $teamModel->select(array(
				'Conditions' => "username = '$username' AND password = '$password'",
				'Limit' => 1
			));
			
			if(empty($team) || empty($team[0])) {
				Core::setFlash('Incorrect username or password');
			} else {
				$_SESSION['team'] = $team[0];
				
				$id = $team[0]['id'];
				header('location: ' . ROOT . DS . 'teams' . DS . 'view' . DS . $id);
				exit();
			}
		}
	}
	
	public function logout() {
		if(isset($_SESSION['team'])){
			unset($_SESSION['team']);
		}
		
		header('location: ' . ROOT . DS . 'teams' . DS . 'login');
	}
}
