<?php

include 'Database.php';
include 'controllers/Controller.php';
include 'models/Model.php';

class Core {
	
	private static $flash;
	
	public function run($_controller, $_action, $parameters) {
		
		$this->handleFlash();
		
		// Create Controller
		$controller = $this->getControllerObject($_controller);

		if(!isset($controller)) {
			header('HTTP/1.0 404 NOT FOUND');
			exit();
		}
		
		// Include models
		$this->includeModels($controller->getModels());
		
		// Call action and render the page
		if(method_exists($controller, $_action)) {
			
			$controller->before();
			
			call_user_func_array(array($controller, $_action), $parameters);

			$this->render($controller, $_action);
			exit;
		}

		header('HTTP/1.0 404 NOT FOUND');
		exit();
	}
	
	public static function hash($str) {
		return sha1($str);
	}
	
	public static function enforceLogin() {
		$validUrls = array(
			'users' . DS . 'login',
			'users' . DS . 'add'
		);
		
		if(!isset($_SESSION['user'])){
			if(!empty($_GET['url'])) {
				if(!in_array($_GET['url'], $validUrls)) {
					header('location: ' . ROOT . DS . 'users' . DS . 'login');
					exit();
				}
			}
			
		}
	}
	
	private function getControllerObject($_controller) {
		$class = $_controller . 'Controller';
		$filename = 'controllers' . DS . $class . '.php';
		
		$controller = null;
		
		if(is_file($filename)) {
			require $filename;
			$controller = new $class();
		}
		
		return $controller;
	}
	
	private function includeModels($models) {
		
		foreach($models as $model) {
			include 'models' . DS . $model . '.php';
		}
	}
	
	private function render($controller, $_action) {
		extract($controller->getVars());
		
		ob_start();
		
		include 'views' . DS . $controller->getName() . DS . $_action . '.php';
		
		$content_for_layout = ob_get_clean();
		
		$layout = $controller->getLayout();
		
		include 'views' . DS . 'layouts' . DS . $layout . '.php';
	}
	
	public static function setFlash($message) {
		$_SESSION['flash'] = $message;
		self::$flash = $message;
	}
	
	public static function getFlash() {
		if(!empty(self::$flash)) {
			print('<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>' . self::$flash . '</div>'); 
		}
	}
	
	private static function handleFlash() {
		if(isset($_SESSION['flash'])) {
			self::$flash = $_SESSION['flash'];
			unset($_SESSION['flash']);
		} else {
			self::$flash = '';
		}
	}
}