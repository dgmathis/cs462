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
}
