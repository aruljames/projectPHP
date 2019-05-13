<?php	

define('DS', DIRECTORY_SEPARATOR);
define('_ROOT', dirname(dirname(__FILE__)));

$url = $_GET['url'];

require_once (_ROOT . DS . 'library' . DS . 'bootstrap.php');
