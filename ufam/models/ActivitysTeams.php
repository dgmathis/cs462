<?php

class ActivitysTeamsModel extends Model {

	public function unjoinActivity($activityId, $teamId) {
		$query = "DELETE FROM activitys_teams WHERE activity_id = '$activityId' AND team_id='$teamId';";

		return $this->query($query);
	}
	
	public function joinActivity($activityId, $teamId) {
		
		$data['activity_id'] = $activityId;
		$data['team_id'] = $teamId;
		
		$result = $this->insert($data);
		
		return $result;
	}
	
}
