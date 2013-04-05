<?php

class V1 extends API {
	
	public function rqf_get_activities($id) {
		
		$activitysModel = $this->getModel('Activitys');

		$curTime = date('Y-m-d H:i:s');
		
		$activities = $activitysModel->select(array(
			'Conditions' => "date >= $curTime"
		));
		
		print $activities;
		die();
	}
}
