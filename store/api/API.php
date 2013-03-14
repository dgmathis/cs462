<?php

class API {
	
	public function getModel($modelName) {
		$class = $modelName . 'Model';
		
		include_once 'models' . DS . $modelName . '.php';
		
		$model = new $class();
		
		return $model;
	}
	
}
