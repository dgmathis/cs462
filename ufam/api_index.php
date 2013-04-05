<?php

session_start();

date_default_timezone_set('America/Denver');

define('DS', '/');
define('ROOT', DS . basename(dirname(dirname(__FILE__))) . DS . basename(dirname(__FILE__)));
define('ESL', 'http://' . $_SERVER['SERVER_NAME'] . ROOT . DS . 'api' . DS . 'v1' . DS . 'receive_event');

require 'skel' . DS . 'api' . DS . 'API.php';
require 'skel' . DS . 'models' . DS . 'Model.php';
require 'core' . DS . 'DBConfig.php';
require 'skel' . DS . 'core' . DS . 'Database.php';

$version = $_GET['version'];
$action = $_GET['action'];
$params = (!empty($_GET['params'])) ? explode('/', $_GET['params']) : array();

$class = "V$version";
$filename = "api" . DS . $class . '.php';

require $filename; 

$api = new $class;

call_user_func_array(array($api, $action), $params);


