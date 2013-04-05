<?php

class V1 extends API {
	
	public function rqf_delivery_ready($id) {
		
		if(!empty($_POST)) {
			
			$deliveryId = $_POST['delivery_id'];
			
			if(empty($deliveryId)) {
				print("Please provide a delivery id");
				die();
			}
			
			$storesModel = $this->getModel('Stores');
			
			$storeData = $storesModel->select(array(
				'Conditions' => "id = '$id'",
				'Limit' => 1
			));
			
			if(empty($storeData)) {
				print("No store registered with the provide esl " . $id);
				die();
			}
			
			$store = $storeData[0];
			
			$event['_domain'] = 'rfq';
			$event['_name'] = 'delivery_ready';
			$event['store_lat'] = $store['lat'];
			$event['store_lng'] = $store['lng'];
			$event['bid_callback_url'] = $_POST['bid_callback_url'];
			$event['delivery_id'] = $deliveryId;
			$event['pickup_time'] = (isset($_POST['pickup_time'])) ? $_POST['pickup_time'] : null;
			$event['pickup_address'] = (isset($_POST['pickup_address'])) ? $_POST['pickup_address'] : null;
			$event['delivery_time'] = (isset($_POST['delivery_time'])) ? $_POST['delivery_time'] : null;
			$event['delivery_address'] = (isset($_POST['delivery_address'])) ? $_POST['delivery_address'] : null;
			
			// send to drivers;
			$this->forwardDeliveryReady($event);
			
			print('received');
			die();
		}
	}
	
	private function forwardDeliveryReady($event) {
		$driversModel = $this->getModel('Drivers');
			
		$drivers = $driversModel->select(array(
			'Limit' => 3,
			'Order' => 'rating DESC'
		));
		
		$result = "Sent delivery ready request to";

		foreach($drivers as $driver) {
			$esl = $driver['esl'];
			
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $esl);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($event));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);
			
			curl_close ($ch);
			
			if($server_output !== false && strcasecmp(trim($server_output), "received") != 0) {
				print('Failed to send request to driver: ' . $server_output);
				die();
			}
			
			$result .= " " . $driver['guid'] . ",";
		}
		
		$result = trim($result, ',');
		
		print($result);
		die();
	}
	
	public function rfq_bid_awarded($id) {
		$event['_domain'] = 'rfq';
		$event['_name'] = 'bid_awarded';
		$event['delivery_id'] = $_POST['delivery_id'];
		
		$driversModel = $this->getModel('Drivers');
		
		$driver = $driversModel->getByField('guid', $_POST['driver_guid']);
		
		if($driver === false) {
			print("Driver does not exist");
			die();
		}
		
		$esl = $driver['esl'];
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $esl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($event));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);
		
		curl_close($ch);
		
		if($server_output === false) {
			$server_output = '';
		}
		
		if(strcasecmp(trim($server_output), "received") != 0) {
			print("Failed to send bid awarded request: " . $server_output);
			die();
		}
		
		print("received");
		die();
	}
	
	public function delivery_complete($id) {
		
		$driverGUID = $_POST['driver_guid'];
		
		if(empty($driverGUID)) {
			print("Please provide a delivery id and a driver guid");
			die();
		}
		
		$driversModel = $this->getModel('Drivers');
		
		$driver = $driversModel->getByField('guid', $driverGUID);
		
		if($driver == false) {
			print("Driver does not exist");
			die();
		}
		
		$driver['deliverys_completed'] = intval($driver['deliverys_completed']) + 1;

		if(strtotime($_POST['delivery_time']) > strtotime($_POST['completed_time'])) {
			$driver['rating'] = $driver['rating'] + 0.1;
		} else {
			$driver['rating'] = $driver['rating'] - 0.1;
		}
		
		if(floatval($driver['rating']) > 1.0) {
			$driver['rating'] = 1.0;
		} else if(floatval($driver['rating']) < 0.0) {
			$driver['rating'] = 0.0;
		}
		
		if(!$driversModel->update($driver)) {
			print("Failed to update driver");
			die();
		}
		
		print("received");
		die();
	}
	
	public function delivery_picked_up($id) {
		$driversModel = $this->getModel('Drivers');
		
		$driver = $driversModel->getByField('guid', $_POST['driver_guid']);
		
		if($driver == false) {
			print("Driver does not exist");
			die();
		}
		
		if(strtotime($_POST['pickup_time']) > strtotime($_POST['actual_pickup_time'])) {
			$driver['rating'] = $driver['rating'] + 0.1;
		} else {
			$driver['rating'] = $driver['rating'] - 0.1;
		}
		
		if(floatval($driver['rating']) > 1.0) {
			$driver['rating'] = 1.0;
		} else if(floatval($driver['rating']) < 0.0) {
			$driver['rating'] = 0.0;
		}
		
		if(!$driversModel->update($driver)) {
			print("Failed to update driver");
			die();
		}
		
		print("received");
		die();
	}
}
