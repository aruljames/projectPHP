<?php
namespace system\common\Dbconnect;
class Pdo {
	protected $_DBConnection;
    function __construct() {
        if(!is_object($this->_DBConnection)){
            try {
                $DBCONNECTION = new \PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
                $this->_DBConnection = $DBCONNECTION;
            }catch(PDOException $e){
                die("Databse Connection failed: " .$e->getMessage());
            }
        }
    }
    
    function get(){
		return $this->_DBConnection;
	}
    
    function __destruct() {

    }
}
