<?php

class V1 extends API {
	
	public function rfq_get_activities($id) {
		
		$activitysModel = $this->getModel('Activitys');

		$curTime = date('Y-m-d H:i:s');
		
		$activities = $activitysModel->select(array(
			'Conditions' => "date >= '$curTime'"
		));
		
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
		
		$result = $activitysModel->addActivity($activity);
			
		if($result['code'] == 0) {
			print 'Failed to create activity';
		} else {
			print 'success';
		}
		
		die();
	}
}
