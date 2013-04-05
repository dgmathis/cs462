<?php

class Router {
	
	private $controller = null;
	private $action = null;
	private $parameters = null;
	
	public function __construct() {

		// Set defaults
		$this->controller = 'Pages';
		$this->action = 'index';
		$this->parameters = array();
		
		if(isset($_GET['url'])) {
			$url = explode('/', $_GET['url']);
			
			if(!empty($url[0])) {
				$this->controller = ucwords($url[0]);
			}

			if(!empty($url[1])) {
				$this->action = $url[1];
			}
			
			for($i = 2, $len = count($url); $i < $len; $i++) {
				$this->parameters[] = $url[$i];
			}
		}
	}
	
	public function getController() {
		return $this->controller;
	}

	public function getAction() {
		return $this->action;
	}
	
	public function getParameters() {
		return $this->parameters;
	}
}