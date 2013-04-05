<?php

class V1 extends API {
	
	public function rqf_bid_available($guildId) {
		
		if(!empty($_POST)) {
			
			if(empty($guildId)) {
				print('Please provide a Guild id');
				die();
			}
			
			$guildsModel = $this->getModel('Guilds');
			
			$guildData = $guildsModel->select(array(
				'Conditions' => "id = '$guildId'",
				'Limit' => 1
			));
			
			if(empty($guildData)) {
				print('Guild does not exist.');
				die();
			}
			
			$driverGUID = $_POST['driver_guid'];
			
			if(empty($driverGUID)) {
				print('Please provide a driver globally unique id');
				die();
			}
			
			$deliveryId = $_POST['delivery_id'];
			
			if(empty($deliveryId)) {
				print('Please provide a delivery Id');
				die();
			}

			// update bid
			$data['driver_guid'] = $driverGUID;
			$data['guild_id'] = $guildId;
			$data['delivery_id'] = $deliveryId;
			$data['est_delivery_time'] = $_POST['est_delivery_time'];
			$bidsModel = $this->getModel('Bids');
			if(!$bidsModel->insert($data)) {
				print("Could not save bid in store");
				die();
			}
		
			// Update delivery
			$deliverysModel = $this->getModel('Deliverys');	
			$deliveryData['id'] = $deliveryId;
			$deliveryData['status'] = 'bids received';
			if(!$deliverysModel->update($deliveryData)) {
				print("Could not update delivery in store");
				die();
			}
			
			print('received');
		}
		
		die();
	}
	
	public function delivery_complete($id) {
		
		$deliveryId = $_POST['delivery_id'];
		
		if(empty($deliveryId)) {
			print("Please provide a delivery id");
			die();
		}
		
		$deliverysModel = $this->getModel('Deliverys');
		
		$delivery = $deliverysModel->getById($deliveryId);
		
		if($delivery === false) {
			print("Delivery doesn't exist");
			die();
		}
		
		$delivery['status'] = 'completed';
		
		if(!$deliverysModel->update($delivery)) {
			print("Failed to update delivery status");
			die();
		}
		
		print("received");
		die();
	}
}
