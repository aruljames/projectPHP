<?php

/* Toget the action url */
function get_action_path(){
	$path_info="";
	if(isset($_SERVER['PATH_INFO'])){
		$path_info=$_SERVER['PATH_INFO'];
	}else if(isset($_SERVER['REDIRECT_URL'])){
		$project_path = substr($_SERVER['SCRIPT_NAME'],0,0-(strlen("index.php")));
		$path_info = substr($_SERVER['REDIRECT_URL'], strlen($project_path));
	}else{
		$path_info = "index/index/index";
	}
	$path_info = array_filter(explode('/',strtolower($path_info)));
	if(sizeof($path_info) < 3){
		$path_info[]='index';
		$path_info[]='index';
	}else if(sizeof($path_info) < 2){
		$path_info[]='index';
	}
	return array_values($path_info);
	
	
	/*$script_name = explode('/',$_SERVER['SCRIPT_NAME']);
	$index_index = count($script_name);
	$index_name = $script_name[$index_index-1];
	unset($script_name[$index_index-1]);
	$script_name = implode('/',$script_name);
	$request_url = ltrim($_SERVER['REQUEST_URI'],$script_name);
	if (substr($request_url, 0, strlen($index_name)) == $index_name) {
		$request_url = substr($request_url, strlen($index_name));
	}
	$rejecct_list=array('?','&');
	if(in_array(substr(trim($request_url),0,1),$rejecct_list) || trim($request_url)==''){
		return array('index','index');
	}else{
		$request_url = array_filter(explode('/',$request_url));
		if(sizeof($request_url) < 2){
			$request_url[]='index';
		}
		return $request_url;
	}*/
}

/** Check if environment is development and display errors **/
function setReporting() {
if (DEVELOPMENT_ENVIRONMENT == true) {
	error_reporting(E_ALL);
	ini_set('display_errors','On');
} else {
	error_reporting(E_ALL);
	ini_set('display_errors','Off');
	ini_set('log_errors', 'On');
	ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
}
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

function callHook() {
	$urlArray = get_action_path();
	$page = $urlArray[0];
	array_shift($urlArray);
	$controller_name = $urlArray[0];
	array_shift($urlArray);
	$action_name = $urlArray[0];
	array_shift($urlArray);
	$queryString[] = $urlArray;

	$controller = ucwords($controller_name).'Controller';
	$action = $action_name.'Action';
	$_className = 'front\\controller\\'.$page.'\\'.$controller;
	$dispatch = new $_className($page,$controller_name,$action_name);

	if ((int)method_exists($_className, $action)) {
		call_user_func_array(array($dispatch,$action),$queryString);
	} else {
		/* Error Generation Code Here */
	}
}

/** Autoload any classes that are required **/

function __autoload($className) {
	$nSpaceSplit = explode("\\",$className);
	$code_root = $nSpaceSplit[0];
	if($code_root != "system"){
		array_shift($nSpaceSplit);
		$className = implode(DS,$nSpaceSplit);
		$codePools = array('default');
		foreach($codePools as $codePool){
			$file_path = ROOT . DS . 'app' . DS . 'code' . DS . $code_root . DS . $codePool . DS . $className . '.php';
			//echo $file_path."<br>";
			if (file_exists($file_path)) {
				require_once($file_path);return;
			}
		}
	}else{
		$file_path = ROOT . DS . 'library' . DS . $className . '.php';
		if (file_exists($file_path)) {
			require_once($file_path);return;
		}
	}
}

setReporting();
removeMagicQuotes();
unregisterGlobals();
callHook();
