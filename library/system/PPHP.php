<?php
class PPHP
{
    function __construct() {
    }
    public static function system(){
        return new \system\admin\Core();
    }
    public static function session($group=null){
        return new \system\front\Session($group);
    }
    // need to create a function to get class name 
    function __destruct() {
        
    }
}

