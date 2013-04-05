<?php

class GuildsModel extends Model {
	
	public function addGuild($guild) {
		$result = $this->validateGuild($guild);
		
		if($result['code'] == 0) {
			return $result;
		}
		
		if(!$this->insert($guild)) {
			return array('code' => 0, 'message' => 'Failed to add guild.  Unknown reason');
		}
		
		return array('code' => 1, 'message' => 'Successfully added user.');
	}
	
	public function updateGuild($guild) {
		
		$result = $this->validateGuild($guild);
		
		if($result['code'] == 0) {
			return $result;
		}

		if(!$this->update($guild)) {
			return array('code' => 0, 'message' => 'Failed to edit guild.  Unknown reason');
		}
		
		return array('code' => 1, 'message' => 'Successfully edited guild.');
		
	}
	
	public function validateGuild($guild) {

		if(empty($guild['name'])) {
			return array('code' => 0, 'message' => 'Please provide a username.');
		}
		
		if(empty($guild['esl'])) {
			return array('code' => 0, 'message' => 'Please provide an esl.');
		}
		
		return array('code' => 1);
	}
}