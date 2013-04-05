<?php

class ActivitysModel extends Model {
	
	public function addActivity($activity) {

		$result = $this->validateActivity($activity);
		
		if($result['code'] == 0) {
			return $result;
		}

		$activity['date'] = $this->formatDate($activity['date']);
		
		if(!$this->insert($activity)) {
			return array('code' => 0, 'message' => 'Failed to add activity.  Unknown reason');
		}
		
		return array('code' => 1, 'message' => 'Successfully added activity.');
	}
	
	private function formatDate($date) {
		return date('Y-m-d H:i:s', strtotime($date));
	}
	
	public function updateActivity($activity) {
		
		$result = $this->validateActivity($activity);
		
		if($result['code'] == 0) {
			return $result;
		}

		$activity['date'] = $this->formatDate($activity['date']);
		
		if(!$this->update($activity)) {
			return array('code' => 0, 'message' => 'Failed to edit activity.  Unknown reason');
		}
		
		return array('code' => 1, 'message' => 'Successfully edited activity.');
		
	}
	
	public function validateActivity($activity) {
		if(empty($activity['title'])) {
			return array('code' => 0, 'message' => 'Please provide a title.');
		}
		
		if(empty($activity['date'])) {
			return array('code' => 0, 'message' => 'Please provide a date.');
		}
		
		if(empty($activity['location'])) {
			return array('code' => 0, 'message' => 'Please provide a location.');
		}
		
		return array('code' => 1);
	}
	
	public function getActivitysByTeam($teamId) {
		$activitys = $this->select(array(
			'Conditions' => "team_id = '$teamId'",
			'Join' => "INNER JOIN activitys_teams ON (activitys.id = activitys_teams.activity_id)"
		));
		
		return $activitys;
	}
}
