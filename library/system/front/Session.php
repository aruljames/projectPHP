<?php
namespace system\front;
class Session {
    protected  $__group;
    function __construct($group = 'default') {
        $this->__group = $group;
    }
	public function set($key,$value=null){
	    if($value==null && is_array($key)){
	        foreach($key as $key => $value){
	            $_SESSION['front'][$this->__group][$key]=$value;
	        }
	        return true;
	    }else if(!is_array($key) && ($_SESSION['front'][$this->__group][$key]=$value)){
	        return true;
	    }
	    return false;
	}
	public function get($key=null){
	    if($key){
	        return isset($_SESSION['front'][$this->__group][$key])?$_SESSION['front'][$this->__group][$key]:null;
	    }else{
	        return isset($_SESSION['front'][$this->__group])?$_SESSION['front'][$this->__group]:array();
	    }
	    return false;
	}
	public function clear($key=null){
	    if($key){
	        if(isset($GLOBALS['_SESSION']['front'][$this->__group][$key])){
	            unset($GLOBALS['_SESSION']['front'][$this->__group][$key]);
	        }
	        return true;
	    }else{
	        unset($GLOBALS['_SESSION']['front'][$this->__group]);
	        return true;
	    }
	    return false;
	}
	public function __get($name){
	    return $this->get($name);
	}
	public function __set($name,$value) {
	    return $this->set($name,$value);
	}
}
