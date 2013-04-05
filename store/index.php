<?php 

session_start();

date_default_timezone_set('America/Denver');

// Define constants
define('DS', '/');
define('ROOT', DS . basename(dirname(dirname(__FILE__))) . DS . basename(dirname(__FILE__)));
define('SHARED', DS . basename(dirname(dirname(__FILE__))) . DS . 'skel');
define('ESL', 'http://' . $_SERVER['SERVER_NAME'] . ROOT . DS . 'api' . DS . 'v1' . DS . 'receive_event');

require 'core' . DS . 'DBConfig.php';
require 'skel' . DS . 'core' . DS . 'Core.php';

$router = new Router();
$core = new Core();

$core->run($router->getController(), $router->getAction(), $router->getParameters());
