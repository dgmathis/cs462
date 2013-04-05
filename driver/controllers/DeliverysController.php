<?php

class DeliverysController extends Controller {
	
	var $models = array('Deliverys', 'Settings', 'Guilds');
	
	public function place_bid() {
		Core::setFlash("Manually Placing a bid is not implemented yet. sorry");
		header('Location: ' . ROOT);
		die();
	}
	
	public function complete_delivery($id) {
		
		$settingsModel = new SettingsModel();
		$deliverysModel = new DeliverysModel();
		$guildsModel = new GuildsModel();
		
		$delivery = $deliverysModel->getById($id);
		
		if($delivery === false) {
			Core::setFlash("Delivery doesn't exist");
			header('Location: ' . ROOT);
			die();
		}
		
		$event['_domain'] = 'delivery';
		$event['_name'] = 'complete';
		$event['delivery_id'] = $delivery['ext_delivery_id'];
		$event['delivery_time'] = $delivery['delivery_time'];
		$event['driver_guid'] = $settingsModel->getValue('guid');
		$event['completed_time'] = date('Y-m-d H:i:s');
		
		$storeESL = $delivery['store_esl'];
		
		$guildESL = $guildsModel->getValueByField('id', $delivery['guild_id'], 'esl');
		
		if($guildESL === false) {
			Core::setFlash("Could not get Guild ESL");
			header('Location: ' . ROOT);
			die();
		}
		
		$this->sendEvent($event, $guildESL);
		$this->sendEvent($event, $storeESL);
		
		$delivery['status'] = 'completed';
		
		if(!$deliverysModel->update($delivery)) {
			Core::setFlash("Failed to update delivery");
			header('Location: ' . ROOT);
			die();
		}
		
		Core::setFlash("Delivery Completed");
		header('Location: ' . ROOT);
		die();
	}
	
	private function sendEvent($event, $esl) {
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $esl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($event));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$output = curl_exec($ch);
		
		curl_close($ch);
		
		if($output === false) {
			Core::setFlash("Failed to send event to " . $esl);
			header('Location: ' . ROOT);
			die();
		}
		
		if(strcasecmp(trim($output), 'received') != 0) {
			Core::setFlash("Failed to send event to " . $esl . ": " . $output);
			header('Location: ' . ROOT);
			die();
		}
	}
}