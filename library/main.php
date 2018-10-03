<?php

$configFilePath = ROOT . DS . 'config' . DS . 'env' . DS . ENV . '.php';
require_once($configFilePath);
$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
define ('HTTP_PROTOCOL',$protocol);
/* Toget the action url */
function getActionPath($pathInfo = null){
    if($pathInfo == null){
    	if(isset($_SERVER['PATH_INFO'])){
    		$pathInfo=$_SERVER['PATH_INFO'];
    	}else if(isset($_SERVER['REDIRECT_URL'])){
    		$projectPath = substr($_SERVER['SCRIPT_NAME'],0,0-(strlen("index.php")));
    		$pathInfo = substr($_SERVER['REDIRECT_URL'], strlen($projectPath));
    	}else{
    		$pathInfo = "index/index/index";
    	}
    }
	$pathInfo = array_filter(explode('/',strtolower($pathInfo)));
	if(sizeof($pathInfo) < 3){
		$pathInfo[]='index';
		$pathInfo[]='index';
	}else if(sizeof($pathInfo) < 2){
		$pathInfo[]='index';
	}
	return array_values($pathInfo);
}

/** Check if environment is development and display errors **/
function setReporting() {
    if (ENABLE_LOG == true) {
    	error_reporting(E_ALL);
    	ini_set('display_errors','On');
    } else {
    	error_reporting(E_ALL);
    	ini_set('display_errors','Off');
    }
    ini_set('log_errors', 'On');
    ini_set('error_log', ROOT . DS . 'var' . DS . 'logs' . DS . 'system.log');
}

/** Check for Magic Quotes and remove them **/

function stripSlashesDeep($value) {
	$value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
	return $value;
}

function removeMagicQuotes() {
if ( get_magic_quotes_gpc() ) {
	$_GET    = stripSlashesDeep($_GET   );
	$_POST   = stripSlashesDeep($_POST  );
	$_COOKIE = stripSlashesDeep($_COOKIE);
}
}

/** Check register globals and remove them **/

function unregisterGlobals() {
    if (ini_get('register_globals')) {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

/** Main Call Function **/

function callHook($urlArray = null,$data=array()) {
	$codeBase = 'front';
	if($urlArray == null)
	   $urlArray = getActionPath();
	$page = $urlArray[0];
	array_shift($urlArray);
	if($page == strtolower(ADMIN_URL_PATH)){
		$codeBase = 'admin';
		$page = $urlArray[0];
		array_shift($urlArray);
		if(sizeof($urlArray) < 2){
			$urlArray[]='index';
		}
	}
	$controllerName = $urlArray[0];
	array_shift($urlArray);
	$actionName = $urlArray[0];
	array_shift($urlArray);
	$queryString[] = array_merge($urlArray,$data);
	$controller = ucwords($controllerName).'Controller';
	$action = $actionName.'Action';
	$_className = $codeBase.'\\controller\\'.$page.'\\'.$controller;
	$dispatch = new $_className($page,$controllerName,$actionName);

	if ((int)method_exists($_className, $action)) {
	    call_user_func_array(array($dispatch,$action),$queryString);
	} else {
		/* Error Generation Code Here */
	}
}

setReporting();
removeMagicQuotes();
unregisterGlobals();
callHook();