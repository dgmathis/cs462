<?php 

session_start();

date_default_timezone_set('America/Denver');

// Define constants
define('DS', '/');
define('ROOT', DS . basename(dirname(__FILE__)));

require 'core' . DS . 'Core.php';
require 'core' . DS . 'Router.php';

function debug($arr){
    $retStr = '<ul>';
    if (is_array($arr)){
        foreach ($arr as $key=>$val){
            if (is_array($val)){
                $retStr .= '<li>' . $key . ' => ' . debug($val) . '</li>';
            }else{
                $retStr .= '<li>' . $key . ' => ' . $val . '</li>';
            }
        }
    }
    $retStr .= '</ul>';
    return $retStr;
}

$router = new Router();
$core = new Core();

$core->run($router->getController(), $router->getAction(), $router->getParameters());
