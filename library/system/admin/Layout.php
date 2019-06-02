<?php
namespace system\admin;
class Layout {

    protected $variables = array();
    protected $blocks = array();
    protected $_layout = 'default';
    protected $_page;
    protected $_controller;
    protected $_action;
    protected $_layout_path;


    function __construct($layout = 'default') {
        $this->_layout = $layout;
        $this->_page = \PPHP::session('core')->page;
        $this->_controller = \PPHP::session('core')->controller;
        $this->_action = \PPHP::session('core')->action;
        $this->_layout_path = $this->_page.'\\'.$this->_controller.'\\'.$this->_action;
        $this->blocks['head'] = $this->getBlock('head')->setModel('html/head')->setTemplate('html/head');
        $this->blocks['header'] = $this->getBlock('header')->setModel('html/header')->setTemplate('html/header');
        $this->blocks['foot'] = $this->getBlock('foot')->setModel('html/foot')->setTemplate('html/foot');
        $this->blocks['footer'] = $this->getBlock('footer')->setModel('html/footer')->setTemplate('html/footer');
    }

    /** Set Variables **/

    function set($name,$value) {
            $this->variables[$name] = $value;
    }
    function setValues($value) {
        if(is_array($value)){
        $variables = $this->variables;
        $variables = array_merge($variables,$value);
        $this->variables = $variables;
        return true;
        }
        return false;
    }
    
    function renderLayout($layout = null){
        if(!$layout){
                $layout = $this->_layout;
        }
        $layouts = array_filter(explode('/',$layout));
        $layout = implode(DS,$layouts);
        $codePools = array('default');
        foreach($codePools as $codePool){
            $file_path = _ROOT . DS . 'app' . DS . 'code' . DS . 'admin' . DS . $codePool . DS . 'view' . DS . 'layout' . DS . $layout . '.php';
            //echo $file_path."<br>";
            if (file_exists($file_path)) {
                include($file_path);return;
            }
        }
        foreach($codePools as $codePool){
            $file_path = _ROOT . DS . 'app' . DS . 'design' . DS . 'admin' . DS . $codePool . DS . 'layout' . DS . $layout . '.php';
            //echo $file_path."<br>";
            if (file_exists($file_path)) {
                include($file_path);return;
            }
        }
    }
	
    function importLayout($layout = 'default'){
        $this->renderLayout($layout);
    }
    
    function setBlock($block = 'default',$data = ''){
        $this->blocks[$block] = $data;
    }
	
    function getBlock($block = 'content'){
        if (array_key_exists($block, $this->blocks)){
            return $this->blocks[$block];
        }else{
            $blockObject = new \system\admin\Block($block,$this->_layout);
            $this->blocks[$block] = $blockObject;
            return $blockObject;
        }
    }

    public function getLayout($layout = null){
        if(!$layout){
            $layout = $this->_layout;
        }
        return new \system\admin\Layout($layout);
    }
    
    function __get($name){
        if (array_key_exists($name, $this->variables)) {
            return $this->variables[$name];
        }
    }
    function __set($name,$value) {
        $this->variables[$name] = $value;
    }
    function __call($method,$data=null){
        return $this;
    }
}
