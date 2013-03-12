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
			
			$count = count($url);
			
			if($count > 1) {
				$this->controller = ucwords($url[0]);
				$this->action = $url[1];
				$start = 2;
			} else if($count > 0) {
				$this->action = $url[0];
				$start = 1;
			} else {
				$start = 0;
			}
			
			for($i = $start; $i < $count; $i++) {
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