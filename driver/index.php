<?php 

session_start();

date_default_timezone_set('America/Denver');

// Define constants
define('DS', '/');
define('ROOT', DS . 'cs462' . DS . basename(dirname(__FILE__)));

require 'core' . DS . 'Core.php';
require 'core' . DS . 'Router.php';

$router = new Router();
$core = new Core();

$core->run($router->getController(), $router->getAction(), $router->getParameters());
