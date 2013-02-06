<?php 

session_start();

// Define constants
define('DS', '/');
define('ROOT', DS . basename(dirname(__FILE__)));

require 'core' . DS . 'Core.php';
require 'core' . DS . 'Router.php';

$router = new Router();
$core = new Core();

$core->run($router->getController(), $router->getAction(), $router->getParameters());
