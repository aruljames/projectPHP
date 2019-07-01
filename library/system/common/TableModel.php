<?php
namespace system\common;
class TableModel {
    protected $_tableName;
    protected $_filters = array();
    protected $_keyAttribute = 'id';
    protected $_key = 0;
    protected $_data = array();
    function __construct($tableName) {
       $this->_tableName = $tableName;
    }

    function load($id){
        $this->_key = $id;
        $this->addFilter($this->_keyAttribute,"eq",$this->_key);
        return $this;
    }

    function setData($data = array()){
        $this->_data = array_merge($this->_data,$data);
        return $this;
    }

    function save(){
        if($this->_key){
            $sql="UPDATE `".$this->_tableName."`".$this->getInsertData().$this->getFilterQuery();
        }else{
            $sql="INSERT INTO `".$this->_tableName."`".$this->getInsertData();
        }
        if (\PPHP::DB()->get()->query($sql) === TRUE) {
            return true;
        }
        return false;
    }

    function getInsertData(){
        $_returnDataString = '';
        foreach($this->_data as $param => $value){
            if($_returnDataString == ''){
                $_returnDataString .= ' SET ';
            }else{
                $_returnDataString .= ', ';
            }
            $_returnDataString .= $param . '="'.$value.'"';
        }
        return $_returnDataString;
    }
    
    public function addFilter($val1,$val2 = null,$val3 = null){
        if(is_array($val1)){
            return $this->addFilters($val1);
        }else if($val1 != null && ($val2 != null && $val3 != null)){
            $filter['field'] = $val1;
            $filter['condition'] = strtolower($val2);
            $filter['value'] = $val3;
            $this->_filters[][] = $filter;
        }else if($val1 != null && $val2 != null){
            if(is_array($val2)){
                foreach($val2 as $condition => $value){
                    $filter['field'] = $val1;
                    $filter['condition'] = strtolower($condition);
                    $filter['value'] = $value;
                    $filters[] = $filter;
                }
                $this->_filters[] = $filters;
            }else{
                $filter['field'] = $val1;
                $filter['condition'] = 'eq';
                $filter['value'] = $val2;
                $this->_filters[][] = $filter;
            }
        }else if($val1 != null){
            $filter['field'] = $val1;
            $filter['condition'] = 'NULL';
            $filter['value'] = null;
            $this->_filters[][] = $filter;
        }
    }
    
    public function addFilters($filters){
        if(is_array($filters)){
            $this->_filters[] = $this->getfiltersFromArray($filters);
        }else{
            return $this->addFilter($filters);
        }
    }
    
    private function getfiltersFromArray($filterIn){
        $filters = array();
        $singleFilter = false;
        foreach($filterIn as $param => $value){
            if(is_numeric($param)){
                if(is_array($value)){
                    $filters[] = $this->getfiltersFromArray($value);
                }else{
                    $singleFilter = true;
                    break;
                }
            }else if(is_array($value)){
                foreach($value as $condition => $values){
                    if(is_numeric($condition)){
                        if(is_array($values)){
                            foreach($values as $valkey => $valval){
                                $filter['field'] = $param;
                                $filter['condition'] = strtolower($valkey);
                                $filter['value'] = $valval;
                                $filters[] = $filter;
                            }
                        }else{
                            $filter['field'] = $param;
                            $filter['condition'] = 'in';
                            $filter['value'] = $value;
                            $filters[] = $filter;
                            break;
                        }
                    }else{
                        $filter['field'] = $param;
                        $filter['condition'] = strtolower($condition);
                        $filter['value'] = $values;
                        $filters[] = $filter;
                    }
                }
            }else{
                $filter['field'] = $param;
                $filter['condition'] = 'eq';
                $filter['value'] = $value;
                $filters[] = $filter;
            }
        }
        if($singleFilter){
            if(isset($value[0]) && (isset($value[1]) && isset($value[2]))){
                $filter['field'] = $value[0];
                $filter['condition'] = strtolower($value[1]);
                $filter['value'] = $value[2];
                $filters = $filter;
            }else if(isset($value[0]) && isset($value[1])){
                if(is_array($value[1])){
                    foreach($value[1] as $condition => $values){
                        $filter['field'] = $value[0];
                        $filter['condition'] = strtolower($condition);
                        $filter['value'] = $values;
                        $filters[] = $filter;
                    }
                }else{
                    $filter['field'] = $value[0];
                    $filter['condition'] = 'eq';
                    $filter['value'] = $value[1];
                    $filters = $filter;
                }
            }else if(isset($value[0])){
                $filter['field'] = $value[0];
                $filter['condition'] = 'null';
                $filter['value'] = null;
                $filters = $filter;
            }
        }
        return $filters;
    }
    
    public function getFilters(){
        return $this->_filters;
    }

    public function getAll(){
        $sql="SELECT * FROM `".$this->_tableName."` ".$this->getFilterQuery();
        $result = mysqli_query(\PPHP::DB()->get(),$sql);
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    
    public function getFilterQuery(){
        $filterQuery = '';
        foreach($this->getFilters() as $filters){
            if($filterQuery == ''){
                $filterQuery .= ' WHERE ';
            }else{
                $filterQuery .= ' AND ';
            }
            $orfilters = '';
            foreach($filters as $filter){
                if($orfilters != ''){
                    $orfilters .= ' OR ';
                }else{
                    $orfilters .= ' (';
                }
                $orfilters .= '`'.$filter['field'].'` ';
                if($filter['condition'] == 'eq'){
                    $condition = '= ';
                }else if($filter['condition'] == 'neq'){
                    $condition = '!= ';
                }else if($filter['condition'] == 'nin'){
                    $condition = 'NOT IN (';
                }else if($filter['condition'] == 'in'){
                    $condition = 'IN (';
                }
                $orfilters .= $condition;
                if(is_array($filter['value'])){
                    $value = array();
                    foreach($filter['value'] as $values){
                        $value[]= "'".$values."'";
                    }
                    $value = implode(',', $value);
                }else{
                    $value = "'".$filter['value']."'";
                }
                $orfilters .= $value;
                if($filter['condition'] == 'nin' || $filter['condition'] == 'in'){
                    $orfilters .= ')';
                }
            }
            $orfilters .= ' )';
            $filterQuery .= $orfilters;
        }
        return $filterQuery;
    }
    
    function __destruct() {

    }
}
