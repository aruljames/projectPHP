<?php
namespace system\common;
class Dbconnect {
    protected $_DBConnection;
    function __construct() {
       $this->start();
    }
    
    function start(){
        $connectionClass =  '\\system\\common\\dbconnect\\'.ucwords(DB_SORCE);   
        $dbObject = new $connectionClass();
        $this->_DBConnection = $dbObject->get();
    }
    
    function get(){
        return $this->_DBConnection;
    }
    
    function close(){
        return $this->_DBConnection->close();
    }
    
    function __destruct() {

    }
}
