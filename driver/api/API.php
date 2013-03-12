<?php

class API {
	
	public function getModel($modelName) {
		$class = $modelName . 'Model';
		
		include 'models' . DS . $modelName . '.php';
		
		$model = new $class();
		
		return $model;
	}
	
}
