
<?php

define('DS', '/');
define('ROOT', DS . 'cs462' . DS . basename(dirname(__FILE__)));

require 'api' . DS . 'API.php';
require 'models' . DS . 'Model.php';
require 'core' . DS . 'Database.php';

$version = $_GET['version'];
$action = $_GET['action'];
$params = (!empty($_GET['params'])) ? explode($_GET['params']) : array();

$class = "V$version";
$filename = "api" . DS . $class . '.php';

require $filename; 

$api = new $class;

call_user_func_array(array($api, $action), $params);

