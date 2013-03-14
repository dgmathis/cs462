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
		error_log($_POST);
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
		$settingsModel = $this->getModel('Settings');
			
		$settingsModel->setValue('event_received', json_encode($_POST));
		
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

				$ch = curl_init();

				$bid['_domain'] = 'rqf';
				$bid['_name'] = 'bid_available';
				$bid['delivery_id'] = $deliveryId;
				$bid['driver_esl'] = DRIVER_ESL;
				$bid['driver_name'] = $settingsModel->getValue('firstname') . ' ' . $settingsModel->getValue(lastname);
				$bid['est_delivery_time'] = "20 min";
				
				curl_setopt($ch, CURLOPT_URL, $storeEsl);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($bid));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				
				if(strcasecmp(trim($output), "received") != 0) {
					print($output . "<br />");
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
			
			$sms = $client->account->sms_messages->create(
				"+14355038056", 
				"+18014711664",
				$message
			);

			print('received');
			die();
		}
	}
	
	private function isInRange($storeData) {

		if(empty($storeData)) {
			return false;
		}
		
		$lat1 = $storeData['lat'];
		$lng1 = $storeData['lng'];
		
		$settingsModel = $this->getModel('Settings');
		
		$lat2 = $settingsModel->getValue('last_checkin_lat');
		$lng2 = $settingsModel->getValue('last_checkin_lng');
		
		if(empty($lat1) || empty($lng1) || empty($lat2) || empty($lng2)) {
			return false;
		}
		
		$distance = $this->distance($lat1, $lng1, $lat2, $lng2);
		
		return ($distance < 20);
	}
	
	function distance($lat1, $lng1, $lat2, $lng2, $miles = true)
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
