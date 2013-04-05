<?php

class DeliverysController extends Controller {
	
	var $models = array('Deliverys', 'Bids', 'Guilds');
	var $layout = 'admin';
	
	public function before() {
		if(empty($_SESSION['admin']) && $_SERVER['REQUEST_URI'] != ROOT . '/admin/login') {
			header("location: " . ROOT . "/admin/login");
		}
	}
	
	public function view($id) {
		$deliverysModel = new DeliverysModel();
		
		$delivery = $deliverysModel->getById($id);
		
		if($delivery === false) {
			Core::setFlash('Delivery does not exist');
			header('Location: ' . ROOT . DS . 'deliverys');
			die();
		}

		$accepted_bid_id = $delivery['accepted_bid_id'];
		
		$bidsModel = new BidsModel();
		
		$bids = $bidsModel->select(array(
			'Conditions' => "delivery_id = '$id'"
		));
			
		for($i = 0; $i < count($bids); $i++) {
			if(empty($accepted_bid_id)) {
				$bids[$i]['accepted'] = null;
			} else if($accepted_bid_id == $bids[$i]['id']) {
				$bids[$i]['accepted'] = true;
			} else {
				$bids[$i]['accepted'] = false;
			}
		}
		
		$this->setVar('delivery', $delivery);
		$this->setVar('bids', $bids);
	}
	
	public function accept_bid($id) {
		
		$bidsModel = new BidsModel();
		
		$bidData = $bidsModel->select(array(
			'Conditions' => "id = '$id'",
			'Limit' => 1
		));
		
		if(empty($bidData) || empty($bidData[0])) {
			Core::setFlash("Bid does not exist");
			header('Location: ' . ROOT . DS . 'admin');
			die();
		}
		
		$bid = $bidData[0];
		
		$deliveryId = $bid['delivery_id'];
		
		$deliverysModel = new DeliverysModel();

		$delivery = $deliverysModel->getById($deliveryId);
		
		if($delivery === false) {
			Core::setFlash('Delivery does not exist');
			header('Location: ' . ROOT . DS . 'admin');
			die();
		}
		
		$guildId = $bid['guild_id'];
		
		$guildsModel = new GuildsModel();
		
		$guild = $guildsModel->getById($guildId);
		
		if($guild === false) {
			Core::setFlash('Guild does not exist');
			header('Location: ' . ROOT . DS . 'admin');
			die();
		}
		
		$guildEsl = $guild['esl'];
		
		$event['driver_guid'] = $bid['driver_guid'];
		$event['delivery_id'] = $deliveryId;
		
		$output = $this->sendBidAwarded($event, $guildEsl);
		
		if($output === false) {
			$output = '';
		}
		
		if(strcasecmp(trim($output), "received") != 0) {
			Core::setFlash('Failed to notify driver: ' . $output);
			header('Location: ' . ROOT . DS . 'deliverys' . DS . 'view' . DS . $deliveryId);
			die();
		}
		
		$data['id'] = $deliveryId;
		$data['status'] = 'bid accepted';
		$data['accepted_bid_id'] = $id;

		if(!$deliverysModel->update($data)) {
			Core::setFlash("Could not update delivery");
			header('Location: ' . ROOT . DS . 'deliverys' . DS . 'view' . DS . $deliveryId);
			die();
		}
		
		Core::setFlash("Bid Accepted");
		header('Location: ' . ROOT . DS . 'deliverys' . DS . 'view' . DS . $deliveryId);
		die();
	}
	
	private function sendBidAwarded($event, $esl) {
		
		$event['_domain'] = 'rfq';
		$event['_name'] = 'bid_awarded';
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $esl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($event));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);

		curl_close ($ch);
		
		return $server_output;
	}
	
	public function picked_up($deliveryId, $bidId) {
		
		$deliverysModel = new DeliverysModel();
		
		$delivery = $deliverysModel->getById($deliveryId);
		
		if($delivery === false) {
			Core::setFlash("Delivery doesn't exist");
			header("Location: " . ROOT . DS . 'deliverys' . DS . 'view' . DS . $deliveryId);
			die();
		}
		
		$bidsModel = new BidsModel();
		
		$bid = $bidsModel->getById($bidId);
		
		if($bid === false) {
			Core::setFlash("Bid doesn't exist");
			header("Location: " . ROOT . DS . 'deliverys' . DS . 'view' . DS . $deliveryId);
			die();
		}
		
		$guildsModel = new GuildsModel();
		
		$guild = $guildsModel->getById($bid['guild_id']);
		
		$esl = $guild['esl'];
		
		$event['_domain'] = 'delivery';
		$event['_name'] = 'picked_up';
		$event['pickup_time'] = $delivery['pickup_time'];
		$event['actual_pickup_time'] = date('Y-m-d H:i:s');
		$event['driver_guid'] = $bid['driver_guid'];
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $esl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($event));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);
		
		if($server_output === false) {
			$server_output = '';
		}
		
		if(strcasecmp(trim($server_output), 'received') != 0) {
			Core::setFlash($server_output);
			header("Location: " . ROOT . DS . 'deliverys' . DS . 'view' . DS . $deliveryId);
			die();
		}

		$delivery['status'] = 'picked up';
		
		if(!$deliverysModel->update($delivery)) {
			Core::setFlash("Failed to update delivery");
			header("Location: " . ROOT . DS . 'deliverys' . DS . 'view' . DS . $deliveryId);
			die();
		}
		
		header("Location: " . ROOT . DS . 'deliverys' . DS . 'view' . DS . $deliveryId);
		die();
	}
}
