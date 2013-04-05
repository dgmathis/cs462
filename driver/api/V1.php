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

			if(strcasecmp(trim($body), 'Bid anyway') == 0) {
				if(!empty($deliveryId)){
					$deliverysModel = $this->getModel('Deliverys');
					
					$deliveryData = $deliverysModel->select(array(
						'Conditions' => "ext_delivery_id = '$deliveryId'",
						'Limit' => 1
					));
					
					if(empty($deliveryData)) {
						error_log("Unable to get Delivery data");
						die();
					}

					$callbackUrl = $deliveryData[0]['store_esl'];
					
					if(empty($callbackUrl)) {
						error_log("Unable to get StoreId");
						die();
					}

					$output = $this->placeBid($deliveryId, $callbackUrl);

					if(strcasecmp(trim($output), "received") != 0) {
						error_log("Unable to send bid to store");
						die();
					}
				}
			}
		}
		die();
	}
	
	public function rfq_bid_awarded($id) {
		$deliveryId = $_POST['delivery_id'];
		
		$deliverysModel = $this->getModel('Deliverys');
		
		$delivery = $deliverysModel->getByField('ext_delivery_id', $deliveryId);
		
		if($delivery === false) {
			print('Delivery does not exist: ' . $deliveryId);
			die();
		}
		
		$delivery['status'] = 'Bid awarded';
		
		if(!$deliverysModel->update($delivery)) {
			print('Failed to update delivery status');
			die();
		}
		
		print('received');
		die();
	}
	
	public function rfq_delivery_ready($id) {
		
		if(!empty($_POST)) {
			
			$deliveryId = $_POST['delivery_id'];
			
			if(empty($deliveryId)) {
				print("Please provide a delivery id");
				die();
			}
			
			$guildsModel = $this->getModel('Guilds');
			
			$guildData = $guildsModel->select(array(
				'Conditions' => "id = '$id'",
				'Limit' => 1
			));
			
			if(empty($guildData)) {
				print("No guild registered with the provide esl");
				die();
			}
			
			$callbackUrl = $_POST['bid_callback_url'];
			
			$data['store_esl'] = $callbackUrl;
			$data['status'] = 'available';
			$data['ext_delivery_id'] = $deliveryId;
			$data['pickup_time'] = (isset($_POST['pickup_time'])) ? $_POST['pickup_time'] : null;
			$data['pickup_address'] = (isset($_POST['pickup_address'])) ? $_POST['pickup_address'] : null;
			$data['delivery_time'] = (isset($_POST['delivery_time'])) ? $_POST['delivery_time'] : null;
			$data['delivery_address'] = (isset($_POST['delivery_address'])) ? $_POST['delivery_address'] : null;
			$data['guild_id'] = $id;
			
			$deliverysModel = $this->getModel('Deliverys');
			
			$deliverysModel->insert($data);
			
			if($this->isInRange($_POST['store_lat'], $_POST['store_lng'])) {

				$output = $this->placeBid($deliveryId, $callbackUrl);
				
				if($output !== false && strcasecmp(trim($output), "received") != 0) {
					print("Unable to send bid to store: " . $output);
					die();
				}
				
				$message = "Delivery \nPickup: " . $data['pickup_time'] . " @ " . $data['pickup_address'] . " \nDelivery: " . $data['delivery_time'] . " @ " . $data['delivery_address'];
			} else {
				$message = "Bid Request \nPickup: " . $data['pickup_time'] . " @ " . $data['pickup_address'] . " \nDelivery: " . $data['delivery_time'] . " @ " . $data['delivery_address'];
			}
			
			
			$this->sendSMSMessage($message);
			
			$settingsModel = $this->getModel('Settings');
			$settingsModel->setValue('last_delivery_id', $deliveryId);

			print('received');
			die();
		}
	}
	
	private function sendSMSMessage($message) {
		
		$settingsModel = $this->getModel('Settings');
		$number = $settingsModel->getValue('driver_phone_number');
		
		if(empty($number)) {
			return;
		}
		
		require "tools/Services/Twilio.php";

		$AccountSid = "AC7d9ec8056fd385de4aa18fae44465175";
		$AuthToken = "af482ee0a457ff774cc55b9ce50a26cb";

		$client = new Services_Twilio($AccountSid, $AuthToken);
		
		$sms = $client->account->sms_messages->create(
			"+14355038056", 
			$number,
			$message
		);
	}
	
	private function placeBid($deliveryId, $callbackUrl) {

		$settingsModel = $this->getModel('Settings');
		
		$bid['_domain'] = 'rqf';
		$bid['_name'] = 'bid_available';
		$bid['driver_guid'] = $settingsModel->getValue('guid');
		$bid['delivery_id'] = $deliveryId;
		$bid['driver_name'] = $settingsModel->getValue('firstname') . ' ' . $settingsModel->getValue('lastname');
		$bid['est_delivery_time'] = strval(rand(5, 45)) . "min";

		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $callbackUrl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($bid));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$output = curl_exec($ch);
		
		if($output !== false) {
			$deliveryModel = $this->getModel('Deliverys');
			$deliveryData = $deliveryModel->select(array(
				'Conditions' => "ext_delivery_id = '$deliveryId'",
				'Limit' => 1
			));

			if(!empty($deliveryData)) {
				$data['id'] = $deliveryData[0]['id'];
				$data['status'] = 'Bid placed';

				$deliveryModel->update($data);
			}
		}
		
		return $output;
	}
	private function isInRange($lat, $lng) {

		if(empty($lat) || empty($lng)) {
			return false;
		}
		
		$lat1 = $lat;
		$lng1 = $lng;
		
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
		
		return ($distance < 40);
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
