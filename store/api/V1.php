<?php

class V1 extends API {
	
	public function receive_event() {
		if(!empty($_POST)) {
			$domain = $_POST['_domain'];
			$eventName = $_POST['_name'];
			
			$function = $domain . '_' . $eventName;
			
			if(method_exists($this, $function)){
				$this->$function();
			} else {
				print($function . ' does not exist');
				die();
			}
		}
		
		print("Where's the POST data?");
		die();
	}
	
	public function rqf_bid_available() {
		
		if(!empty($_POST)) {
			$driverEsl = $_POST['driver_esl'];
			
			if(empty($driverEsl)) {
				print('Please provide a driver ESL');
				die();
			}
			
			$deliveryId = $_POST['delivery_id'];
			
			if(empty($deliveryId)) {
				print('Please provide a delivery Id');
				die();
			}
			
			$usersModel = $this->getModel('Users');
			
			$userData = $usersModel->select(array(
				'Conditions' => "esl = '$driverEsl'",
				'Limit' => 1
			));
			
			if(empty($userData) || empty($userData[0])) {
				print('Failed to retreive user data');
				die();
			}
			
			// update bid
			$userId = $userData[0]['id'];
			$data['user_id'] = $userId;
			$data['delivery_id'] = $deliveryId;
			$data['est_delivery_time'] = $_POST['est_delivery_time'];
			$bidsModel = $this->getModel('Bids');
			$bidsModel->insert($data);
		
			// Update delivery
			$deliverysModel = $this->getModel('Deliverys');	
			$deliveryData['id'] = $deliveryId;
			$deliveryData['status'] = 'bids received';
			$deliverysModel->update($deliveryData);
			
			print('received');
		}
		
		die();
	}
}
