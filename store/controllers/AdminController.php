<?php

class AdminController extends Controller {

	var $models = array('Admin', 'Users', 'Deliverys');
	var $layout = 'admin';
	
	public function before() {
		if(empty($_SESSION['admin']) && $_SERVER['REQUEST_URI'] != ROOT . '/admin/login') {
			header("location: " . ROOT . "/admin/login");
		}
	}
	
	public function index() {
		$userModel = new UsersModel();
		
		$availableUsers = $userModel->select(array(
			'Conditions' => "esl IS NOT NULL"
		));
		
		$deliverysModel = new DeliverysModel();
		
		$deliverys = $deliverysModel->select();
		
		$this->setVar('availableUsers', $availableUsers);
		$this->setVar('deliverys', $deliverys);
	}
	
	public function request_delivery() {
		if(!empty($_POST)) {
	
			$data['pickup_time'] = $_POST['pickup_time'];
			$data['pickup_address'] = $_POST['pickup_address'];
			$data['delivery_time'] = $_POST['delivery_time'];
			$data['delivery_address'] = $_POST['delivery_address'];
			$data['status'] = 'waiting for bids';
			
			$deliverysModel = new DeliverysModel();
			
			if($deliverysModel->insert($data)) {
				$event['_domain'] = 'rqf';
				$event['_name'] = 'delivery_ready';
				$event['_timestamp'] = time();
				$event['store_esl'] = STORE_ESL;
				$event['delivery_id'] = $deliverysModel->getLastInsertId();
				
				foreach($data as $key => $value) {
					$event[$key] = $value;
				}

				$userModel = new UsersModel();

				$availableUsers = $userModel->select(array(
					'Conditions' => "esl IS NOT NULL"
				));

				foreach($availableUsers as $user) {
					$this->send_request($user, $event);
				}
			}
		}
	}
	
	private function send_request($user, $event) {
		$esl = $user['esl'];
		
		$event['driver_firstname'] = $user['firstname'];
		$event['drivet_lastname'] = $user['lastname'];
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $esl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($event));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);

		curl_close ($ch);
		
		if(strcasecmp(trim($server_output), "received") == 0) {
			header('location: ' . ROOT . '/admin');
		} else {
			print($server_output);
			die();
			$message = 'Failed to send request';
			$this->setVar('message', $message);
		}
	}
	
	public function login() {
		
		if(isset($_SESSION['user']) && !isset($_SESSION['admin'])) {
			$this->setVar('message', 'You must log in as an admin to access this part of the site.');
		}
		
		if(!empty($_POST)) {
			$username = $_POST['username'];
			$password = Core::hash($_POST['password']);
			
			$adminModel = new AdminModel();
			
			$admin = $adminModel->select(array(
				'Conditions' => "username = '$username' AND password = '$password'",
				'Limit' => 1
			));
			
			if(empty($admin) || empty($admin[0])) {
				$this->setVar('message', 'Incorrect username or password.');
			} else {
				$_SESSION['admin'] = $admin[0];
				
				$id = $admin[0]['id'];
				header('location: ' . ROOT . DS . 'admin' . DS . 'index' . DS . $id);
				exit();
			}
		}
	}
	
	public function logout() {
		if(isset($_SESSION['admin'])){
			unset($_SESSION['admin']);
		}
		
		header('location: ' . ROOT . DS . 'admin');
	}
}
