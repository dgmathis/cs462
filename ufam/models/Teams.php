<?php

class TeamsModel extends Model {
	
	public function addTeam($team) {
		$username = $team['username'];
		
		$result = $this->validateTeam($team);
		
		if($result['code'] == 0) {
			return $result;
		}
		
		$existing = $this->select(array(
			'Conditions' => "username = '$username'",
			'Limit' => 1
		));
		
		if(!empty($existing)) {
			return array('code' => 0, 'message' => 'Username is already taken.');
		}
		
		$team['password'] = Core::hash($team['password']);
		
		if(!$this->insert($team)) {
			return array('code' => 0, 'message' => 'Failed to add team.  Unknown reason');
		}
		
		return array('code' => 1, 'message' => 'Successfully added team.');
	}
	
	public function updateTeam($team) {
		
		$result = $this->validateTeam($team);
		
		if($result['code'] == 0) {
			return $result;
		}
		
		$team['password'] = Core::hash($team['password']);
		
		if(!$this->update($team)) {
			return array('code' => 0, 'message' => 'Failed to edit team.  Unknown reason');
		}
		
		return array('code' => 1, 'message' => 'Successfully edited team.');
		
	}
	
	public function validateTeam($team) {
		if(empty($team['password'])) {
			return array('code' => 0, 'message' => 'Please provide a password.');
		}
		
		if(empty($team['username'])) {
			return array('code' => 0, 'message' => 'Please provide a username.');
		}
		
		if(empty($team['name'])) {
			return array('code' => 0, 'message' => 'Please provide a firstname.');
		}
		
		if(empty($team['esl'])) {
			return array('code' => 0, 'message' => 'Please provide a lastname.');
		}
		
		return array('code' => 1);
	}
	
	public function getTeamsByActivity($activityId) {
		$teams = $this->select(array(
			'Conditions' => "activity_id = '$activityId'",
			'Join' => "INNER JOIN activitys_teams ON (teams.id = activitys_teams.team_id)"
		));
		
		return $teams;
	}
}
