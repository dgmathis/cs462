<?php

class V1 extends API {
	
	public function store_last_checkin() {
		
		$checkin = json_decode($_POST['checkin'], true);

		error_log($_POST['checkin']);
		
		$results['code'] = 1;
		$results['message'] = 'Success';
		
		$checkinData['name'] = $checkin['venue']['name'];
		$checkinData['lat'] = $checkin['venue']['location']['lat'];
		$checkinData['lng'] = $checkin['venue']['location']['lng'];

		$settingsModel = $this->getModel('Settings');
		
		$settingsModel->setValue('last_checkin', json_encode($checkinData));

		print(json_encode($results));
		die();
	}
	
	public function receive_bid_reply() {
		$settingsModel = $this->getModel('Settings');
		
		$deliveryId = $settingsModel->getValue('last_delivery_id');
		
		if(!empty($_POST)) {
			
			
			$body = !empty($_POST['Body']) ? $_POST['Body'] : '';
			
			error_log("Body: " . $body);
			
			if(strcasecmp(trim($body), 'Bid anyway') == 0) {
				if(!empty($deliveryId)){
					
					error_log("Made it here 1");
					
					$deliverysModel = $this->getModel('Deliverys');
					
					$deliveryData = $deliverysModel->select(array(
						'Conditions' => "ext_delivery_id = '$deliveryId'",
						'Limit' => 1
					));
					
					if(empty($deliveryData)) {
						error_log("Unable to get Delivery data");
						die();
					}
					
					error_log("Made it here 2");
					
					$storeId = $deliveryData[0]['store_id'];
					
					if(empty($storeId)) {
						error_log("Unable to get StoreId");
						die();
					}
					
					error_log("Made it here 3");
					
					$storesModel = $this->getModel('Stores');
					
					$storeData = $storesModel->select(array(
						'Conditions' => "id = '$storeId'",
						'Limit' => 1
					));
					
					error_log("Made it here 4");
					
					if(empty($storeData)) {
						error_log("Unable to get Store data");
						die();
					}
					
					$storeEsl = $storeData[0]['esl'];
					
					error_log("storeEsl: " . $storeEsl);
					
					$output = $this->placeBid($deliveryId, $storeEsl);
					
					error_log("output: " . $output);
					
					if(strcasecmp(trim($output), "received") != 0) {
						error_log("Unable to send bid to store");
						die();
					}
				}
			}
		}
		die();
	}
	
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
	
	public function rqf_delivery_ready() {

		if(!empty($_POST)) {
			
			$storeEsl = $_POST['store_esl'];
			
			if(empty($storeEsl)) {
				print("Please provide a store esl");
				die();
			}
			
			$deliveryId = $_POST['delivery_id'];
			
			if(empty($deliveryId)) {
				print("Please provide a delivery id");
				die();
			}
			
			$storesModel = $this->getModel('Stores');
			
			$storeData = $storesModel->select(array(
				'Conditions' => "esl = '$storeEsl'",
				'Limit' => 1
			));
			
			if(empty($storeData)) {
				print("No store registered with the provide esl");
				die();
			}
			
			$storeId = $storeData[0]['id'];
			
			$data['store_id'] = $storeId;
			$data['status'] = 'available';
			$data['ext_delivery_id'] = $deliveryId;
			$data['pickup_time'] = (isset($_POST['pickup_time'])) ? $_POST['pickup_time'] : null;
			$data['pickup_address'] = (isset($_POST['pickup_address'])) ? $_POST['pickup_address'] : null;
			$data['delivery_time'] = (isset($_POST['delivery_time'])) ? $_POST['delivery_time'] : null;
			$data['delivery_address'] = (isset($_POST['delivery_address'])) ? $_POST['delivery_address'] : null;
			
			$deliverysModel = $this->getModel('Deliverys');
			
			$deliverysModel->insert($data);
			
			if($this->isInRange($storeData[0])) {

				$output = $this->placeBid($deliveryId, $storeEsl);
				
				if(strcasecmp(trim($output), "received") != 0) {
					print("Unable to send bid to store");
					die();
				}
				
				$message = "Delivery \nPickup: " . $data['pickup_time'] . " @ " . $data['pickup_address'] . " \nDelivery: " . $data['delivery_time'] . " @ " . $data['delivery_address'];
			} else {
				$message = "Bid Request \nPickup: " . $data['pickup_time'] . " @ " . $data['pickup_address'] . " \nDelivery: " . $data['delivery_time'] . " @ " . $data['delivery_address'];
			}
			
			require "tools/Services/Twilio.php";

			$AccountSid = "AC7d9ec8056fd385de4aa18fae44465175";
			$AuthToken = "af482ee0a457ff774cc55b9ce50a26cb";

			$client = new Services_Twilio($AccountSid, $AuthToken);
			
			$settingsModel = $this->getModel('Settings');
			$settingsModel->setValue('last_delivery_id', $deliveryId);
			
			$sms = $client->account->sms_messages->create(
				"+14355038056", 
				"+18014711664",
				$message
			);

			print('received');
			die();
		}
	}
	
	
	private function placeBid($deliveryId, $storeEsl) {
		$settingsModel = $this->getModel('Settings');
		
		$ch = curl_init();
		
		$bid['_domain'] = 'rqf';
		$bid['_name'] = 'bid_available';
		$bid['delivery_id'] = $deliveryId;
		$bid['driver_esl'] = DRIVER_ESL;
		$bid['driver_name'] = $settingsModel->getValue('firstname') . ' ' . $settingsModel->getValue('lastname');
		$bid['est_delivery_time'] = "20 min";

		curl_setopt($ch, CURLOPT_URL, $storeEsl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($bid));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$output = curl_exec($ch);
		
		return $output;
	}
	private function isInRange($storeData) {

		if(empty($storeData)) {
			return false;
		}
		
		$lat1 = $storeData['lat'];
		$lng1 = $storeData['lng'];
		
		$settingsModel = $this->getModel('Settings');
		
		$lastCheckin = $settingsModel->getValue('last_checkin');
		
		if(!empty($lastCheckin)) {
			$lastCheckin = json_decode($lastCheckin, true);
			
			$lat2 = $lastCheckin['lat'];
			$lng2 = $lastCheckin['lng'];
		}
		
		if(empty($lat1) || empty($lng1) || empty($lat2) || empty($lng2)) {
			error_log("Couldn't get all lat-lngs");
			return false;
		}
		
		$distance = $this->distance($lat1, $lng1, $lat2, $lng2);
		
		return ($distance < 20);
	}
	
	private function distance($lat1, $lng1, $lat2, $lng2, $miles = true)
	{
		$pi80 = M_PI / 180;
		$lat1 *= $pi80;
		$lng1 *= $pi80;
		$lat2 *= $pi80;
		$lng2 *= $pi80;

		$r = 6372.797; // mean radius of Earth in km
		$dlat = $lat2 - $lat1;
		$dlng = $lng2 - $lng1;
		$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
		$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
		$km = $r * $c;

		return ($miles ? ($km * 0.621371192) : $km);
	}
}
