<?php

class V1 {
	
	public function store_last_checkin() {
		
		error_log($_POST['checkin']);
		print_r($_REQUEST);
		die();
	}
	
	
}
