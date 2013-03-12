<?php

class Controller {
	
	var $name;
	var $variables = array();
	var $layout = 'default';
	var $models = array();
	
	public function __construct() {
		$this->name = str_replace('Controller', '', get_class($this));
	}
	
	public function before() {
		
	}
	
	public function setVar($name, $value) {
		$this->variables[$name] = $value;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getVars() {
		return $this->variables;
	}
	
	public function getLayout() {
		return $this->layout;
	}
	
	public function getModels() {
		return $this->models;
	}
	
}
