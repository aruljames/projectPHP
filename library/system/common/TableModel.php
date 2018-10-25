<?php
namespace system\common;
class TableModel {
    protected $_tableName;
    protected $_filters;
    function __construct($tableName) {
       $this->_tableName = $tableName;
    }
    
    public function addFilter($val1,$val2 = null,$val3 = null){
        if(is_array($val1)){
            $this->addFilters($val1);
        }else if($val1 != null && ($val3 != null && $val2 != null)){
            $filter['field'] = $val1;
            $filter['condition'] = strtolower($val2);
            $filter['value'] = $val3;
            $this->_filters[] = $filter;
        }else if($val1 != null && $val2 != null){
            $filter['field'] = $val1;
            $filter['condition'] = 'eq';
            $filter['value'] = $val2;
            $this->_filters[] = $filter;
        }else if($val1 != null){
            $filter['field'] = $val1;
            $filter['condition'] = 'NULL';
            $filter['value'] = null;
            $this->_filters[] = $filter;
        }
    }
    
    public function addFilters($filters){
        
    }
    
    function getAll(){
        $sql="SELECT * FROM `".$this->_tableName."`";
        $result = mysqli_query(\PPHP::DB()->get(),$sql);
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    
    function __destruct() {

    }
}
