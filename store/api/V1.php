<?php

class V1 extends API {
	
	public function test($id) {
		print($id);die();
	}
	
	public function receive_event($id) {
		if(!empty($_POST)) {
			$domain = $_POST['_domain'];
			$eventName = $_POST['_name'];
			
			$function = $domain . '_' . $eventName;
			
			if(method_exists($this, $function)){
				call_user_func_array(array($this, $function), array($id));
			} else {
				print($function . ' does not exist');
				die();
			}
		}
		
		print("Where's the POST data?");
		die();
	}
	
	public function rqf_bid_available($id) {
		
		if(!empty($_POST)) {
			if(empty($id)) {
				print('Please provide a driver Id');
				die();
			}
			
			$deliveryId = $_POST['delivery_id'];
			
			if(empty($deliveryId)) {
				print('Please provide a delivery Id');
				die();
			}
			
			$usersModel = $this->getModel('Users');
			
			$userData = $usersModel->select(array(
				'Conditions' => "id = '$id'",
				'Limit' => 1
			));
			
			if(empty($userData) || empty($userData[0])) {
				print('Failed to retreive driver data');
				die();
			}
			
			// update bid
			$data['user_id'] = $id;
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
