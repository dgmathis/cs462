<?php

class UsersController extends Controller {
	
	var $models = array('Users');
	
	public function index() {

		$userModel = new UsersModel();
		
		$users = $userModel->select();
		
		$this->setVar('users', $users);
	}
	
	public function before() {
		
	}
	
	public function add() {
		if(!empty($_POST)) {
			// Add a new user
			$data['username'] = $_POST['username'];
			$data['password'] = $_POST['password'];
			$data['firstname'] = $_POST['firstname'];
			$data['lastname'] = $_POST['lastname'];
			
			$userModel = new UsersModel();
			
			$result = $userModel->addUser($data);
			
			if($result['code'] == 0) {
				$this->setVar('message', $result['message']);
			}
			
			$user = $userModel->select(array(
				'Conditions' => "username = '" . $data['username'] . "'",
				'Limit' => 1
			));
			
			if(!empty($user) && !empty($user[0])) {
				$_SESSION['user'] = $user[0];
				
				$id = $user[0]['id'];
				header('location: ' . ROOT . DS . 'users' . DS . 'view' . DS . $id);
				exit();
			}
			
			$this->setVar('data', $data);
		}
	}
	
	public function view($id) {
		if(empty($id)){
			die('Please provide an id for the user.');
		}

		$userModel = new UsersModel();

		$user = $userModel->select(array(
			'Conditions' => "id = '$id'",
			'Limit' => 1
		));

		if(empty($user) || empty($user[0])){
			die('Could not find that user');
		}

		$accessToken = $user[0]['fs_access_token'];
		$checkins = array();
		
		$limit = (isset($_SESSION['user']) && $_SESSION['user']['id'] == $id) ? 20 : 1;

		if(!empty($accessToken)) {

			$url = "https://api.foursquare.com/v2/users/self/checkins?oauth_token=$accessToken&v=20130101&limit=$limit";
		
			$resultJSON = file_get_contents($url);
			
			$result = json_decode($resultJSON, true);

			$checkins = $result['response']['checkins']['items'];
		}
		
		$allowFSAuth = (isset($_SESSION['user']) && $_SESSION['user']['id'] == $user[0]['id']);
		$allowRegisterESL = (isset($_SESSION['user']) && $_SESSION['user']['id'] == $user[0]['id']);
		
		$this->setVar('allowRegisterESL', $allowRegisterESL);
		$this->setVar('allowFSAuth', $allowFSAuth);
		$this->setVar('user', $user[0]);
		$this->setVar('checkins', $checkins);
	}
	
	public function auth_foursquare() {
		include 'tools' . DS . 'FourSquare.php';
		
		$fourSquare = new FourSquare();
		
		if(!isset($_REQUEST['code'])) {
			$fourSquare->requestCode();
		} else {
			
			$code = $_REQUEST['code'];
			$accessToken = $fourSquare->getAccessToken($code);
			
			$user = $_SESSION['user'];
			
			 $user['fs_access_token'] = $accessToken;
			
			$userModel = new UsersModel();
			
			$userModel->update($user);
			
			header('location: ' . ROOT . DS . 'users');
		}
	}
	
	public function register_esl() {
		if(empty($_SESSION['user'])) {
			header('location: ' . ROOT . '/users/login');
		}
		
		if(!empty($_POST)) {
			$data['id'] = $_SESSION['user']['id'];
			$data['esl'] = $_POST['esl'];
			
			$userModel = new UsersModel();
			
			$result = $userModel->update($data);
			
			error_log("result: " . $result);
			
			header('location: ' . ROOT . '/users/view/' . $data['id']);
		}
	}
	
	public function login() {
		if(!empty($_POST)) {
			$username = $_POST['username'];
			$password = Core::hash($_POST['password']);
			
			$userModel = new UsersModel();
			
			$user = $userModel->select(array(
				'Conditions' => "username = '$username' AND password = '$password'",
				'Limit' => 1
			));
			
			if(empty($user) || empty($user[0])) {
				$this->setVar('message', 'Incorrect username or password');
			} else {
				$_SESSION['user'] = $user[0];
				
				$id = $user[0]['id'];
				header('location: ' . ROOT . DS . 'users' . DS . 'view' . DS . $id);
				exit();
			}
		}
	}
	
	public function logout() {
		if(isset($_SESSION['user'])){
			unset($_SESSION['user']);
		}
		
		header('location: ' . ROOT . DS . 'users' . DS . 'login');
	}
}
