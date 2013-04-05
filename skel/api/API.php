<?php

class API {
	
	public function getModel($modelName) {
		$class = $modelName . 'Model';
		
		include_once 'models' . DS . $modelName . '.php';
		
		$model = new $class();
		
		return $model;
	}
	
	public function receive_event($model = null, $id = null) {
		
		$model = ucfirst($model) . 's';
		
		if(!empty($_POST)) {
			$domain = $_POST['_domain'];
			$eventName = $_POST['_name'];
			
			$function = $domain . '_' . $eventName;
			
			$args = array();
			
			if(isset($id)) {
				$args[] = $id;
			}
			
			if(method_exists($this, $function)){
				call_user_func_array(array($this, $function), $args);
			} else {
				print($function . ' does not exist');
				die();
			}
		}
		
		print("Where's the POST data?");
		die();
	}
}
