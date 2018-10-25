<?php
namespace system\common\Dbconnect;
class Mysqli {
	protected $_DBConnection;
    function __construct() {
		if(defined('DB_PORT') && defined('DB_SOCKET')){
			$DBCONNECTION = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT, DB_SOCKET);
		}else if(defined('DB_PORT')){
			$DBCONNECTION = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
		}else{
			$DBCONNECTION = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		}
        
        if (mysqli_connect_error()) {
            die("Databse Connection failed: " . $DBCONNECTION->connect_error);
        }
        $this->_DBConnection = $DBCONNECTION;
    }
    
    function get(){
		return $this->_DBConnection;
	}
    
    function __destruct() {

    }
}
