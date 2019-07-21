<?php
class PPHP
{
    private static $_DBConnection;
    private static $_session = array();
    function __construct() {
        
    }
    public static function DB(){
        if(!is_object(self::$_DBConnection)){
            self::$_DBConnection =  new \system\common\Dbconnect();
        }
        return self::$_DBConnection;
    }
    public static function system(){
        return new \system\admin\Core();
    }
    public static function session($group='_default'){
        if(!isset(self::$_session[$group]) || !is_object(self::$_session[$group])){
            self::$_session[$group] = new \system\common\Session($group);
        }
        return self::$_session[$group];
    }
    public static function setMessage($message,$type='default'){
        $group = 'session_message';
        if(!isset(self::$_session[$group]) || !is_object(self::$_session[$group])){
            self::$_session[$group] = new \system\common\Session($group);
        }
        return self::$_session[$group]->set($type,$message);
    }
    public static function getMessage($type='default'){
        $group = 'session_message';
        if(!isset(self::$_session[$group]) || !is_object(self::$_session[$group])){
            self::$_session[$group] = new \system\Session($group);
        }
        return self::$_session[$group]->get($type);
    }
    public static function tableModel($tableName){
        return new \system\common\TableModel($tableName);
    }
    public static function redirect($path){
        header("Location: ".SITE_URL."/".$path);
        exit;
    }
    public static function getAsset($path){
        return SITE_URL."/app/assets/".$path;
    }
    public static function getAsset2($type,$path,$tags=array()){
        $tagString = ' ';
        foreach($tags as $tag => $value){
            $tagString = $tag.' = '.'"'.$value.'" ';
        }
        switch($type){
            case 'css':
                return '<link rel="stylesheet" href="'.SITE_URL.'/app/assets/styles/'.$path.'"'.$tagString.'>';
               
            break;
            case 'js':
                return '<script src="'.SITE_URL.'/app/assets/scripts/'.$path.'"'.$tagString.'></script>';
            break;
            default:
                return SITE_URL."/app/assets/styles".$path;
            break;
        }
    }
    // need to create a function to get class name 
    function __destruct() {
        
    }
}

