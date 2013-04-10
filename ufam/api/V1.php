<?php

class V1 extends API {
	
	public function rfq_get_activities($id) {
		
		$activitysModel = $this->getModel('Activitys');

		$curTime = date('Y-m-d H:i:s');
		
		$activities = $activitysModel->select(array(
			'Conditions' => "date >= '$curTime'"
		));
		
		$activityIds = $activitysModel->getActivityIdsByTeam($id);
		
		$len = count($activities);
		for($i = 0; $i < $len; $i++) {
			$activities[$i]['already_joined'] = (in_array($activities[$i]['id'], $activityIds)) ? true : false;
		}
		
		print json_encode($activities);
		die();
	}
	
	public function rfq_create_activity($id) {
		
		if(empty($_POST['title'])) {
			print 'Please provide a title for the activity';
			die();
		}
		
		if(empty($_POST['date'])) {
			print 'Please provide a date for the activity';
			die();
		}
		
		if(empty($_POST['location'])) {
			print 'Please provide a location for the activity';
			die();
		}
		
		if(empty($_POST['description'])) {
			print 'Please provide a description for the activity';
			die();
		}
		
		$activitysModel = $this->getModel('Activitys');
		
		$activity['title'] = $_POST['title'];
		$activity['date'] = $_POST['date'];
		$activity['location'] = $_POST['location'];
		$activity['description'] = $_POST['description'];
		$activity['owner_team_id'] = $id;
		
		$result = $activitysModel->addActivity($activity);
			
		if($result['code'] == 0) {
			print 'Failed to create activity';
		} else {
			print 'success';
		}
		
		die();
	}
	
	public function rfq_unjoin_activity($teamId) {
		
		print("MADE IT HERE"); die();
		
		if(empty($teamId)) {
			print "You cannot unjoin that activity";
			die();
		}
		
		$activityId = $_POST['activity_id'];
		
		if(empty($activityId)) {
			print "No activity ID provided";
			die();
		}
		
		$activitysTeamsModel = $this->getModel('Activitys');
		
		if(!$activitysTeamsModel->unjoinActivity($activityId, $teamId)) {
			print "Failed to unjoin that activity";
			die();
		}
		
		print "success";
		die();
	}
	
	public function rfq_join_activity($teamId) {
		
		if(empty($teamId)) {
			print "You cannot unjoin that activity";
			die();
		}
		
		$activityId = $_POST['activity_id'];
		
		if(empty($activityId)) {
			print "No activity ID provided";
			die();
		}
		
		$activitysTeamsModel = new ActivitysTeamsModel();
		
		if(!$activitysTeamsModel->joinActivity($activityId, $teamId)) {
			print "Failed to join that activity";
			die();
		}
		
		print "success";
		die();
	}
}
