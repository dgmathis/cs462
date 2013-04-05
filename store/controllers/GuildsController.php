<?php

class GuildsController extends Controller {
	
	var $models = array('Guilds');
	var $layout = 'admin';
	
	public function before() {
		if(empty($_SESSION['admin']) && $_SERVER['REQUEST_URI'] != ROOT . '/admin/login') {
			header("location: " . ROOT . "/admin/login");
		}
	}
	
	public function index() {
		$guildModel = new GuildsModel();
		
		$guilds = $guildModel->select();
		
		$this->setVar('guilds', $guilds);
	}
	
	public function add() {
		if(!empty($_POST)) {
			
			$data['name'] = $_POST['name'];
			$data['esl'] = $_POST['esl'];
			
			$guildModel = new GuildsModel();
			
			$result = $guildModel->addGuild($data);
			
			if($result['code'] == 0) {
				Core::setFlash($result['message']);
			}
			
			header('location: ' . ROOT . DS . 'guilds' . DS . 'index');
			die();
		}
	}
	
	public function edit($id) {
		
		if(!empty($_POST)) {
			$guild['id'] = $id;
			$guild['name'] = $_POST['name'];
			$guild['esl'] = $_POST['esl'];
			
			$guildModel = new GuildsModel();
			
			$result = $guildModel->updateGuild($guild);
			
			Core::setFlash($result['message']);
			
			if($result['code'] == 1) {
				header('location: ' . ROOT . DS . 'guilds' . DS . view . DS . $id);
				die();
			}
			
			$this->setVar('guild', $guild);
		} else {
			$guildModel = new GuildsModel();
			
			$guildData = $guildModel->select(array(
				'Conditions' => "id = '$id'",
				'Limit' => 1
			));
			
			if(empty($guildData)) {
				Core::setFlash('Sorry, but that driver does not exist');
				header('location: ' . ROOT . DS . 'guilds');
				die();
			}
			
			$this->setVar('guild', $guildData[0]);
		}
	}
	
	public function view($id) {
		if(empty($id)){
			die('Please provide an id for the guild.');
		}

		$guildModel = new GuildsModel();

		$guild = $guildModel->select(array(
			'Conditions' => "id = '$id'",
			'Limit' => 1
		));

		if(empty($guild) || empty($guild[0])){
			die('Could not find that guild');
		}

		$this->setVar('guild', $guild[0]);
	}
	
	public function delete($id) {
		if(!empty($id)) {
			$guildModel = new GuildsModel();
			$guildModel->delete($id);
		}
		
		header("Location: " . ROOT . DS . 'guilds');
		die();
	}
	
	public function gen_esl() {
		$guildsModel = new GuildsModel();
		
		$data['name'] = 'reserved';
		
		$result = $guildsModel->insert($data);
		
		if($result['code'] == 0) {
			Core::setFlash('Failed to reserve esl');
		}
		
		$id = $guildsModel->getLastInsertId();
		
		$esl = ESL . DS . 'guild' . DS . $id;
		
		$this->setVar('esl', $esl);
	}
}