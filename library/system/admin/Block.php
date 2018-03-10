<?php
namespace system\admin;
class Block {
    protected $_blockData;
    protected $_page;
    protected $_controller;
    protected $_action;
    protected $_template_path;
    function __construct($block) {
        $this->_page = \PPHP::session('core')->page;
        $this->_controller = \PPHP::session('core')->controller;
        $this->_action = \PPHP::session('core')->action;
        $this->_template_path = $this->_page.'\\'.$this->_controller.'\\'.$this->_action;
	    if(is_array($block) && !empty($block)){
	        if(isset($block['class'])){
	            
	        }else if(isset($block['template'])){
	            $codePools = array('default');
	            $template_path = $this->_template_path;
	            foreach($codePools as $codePool){
	                $file_path = ROOT . DS . 'app' . DS . 'code' . DS . 'front' . DS . $codePool . DS . 'view' . DS . 'template' . DS . $template_path . '.php';
	                if (file_exists($file_path)) {
	                    include($file_path);return;
	                }
	            }
	            foreach($codePools as $codePool){
	                $file_path = ROOT . DS . 'app' . DS . 'design' . DS . 'front' . DS . $codePool . DS . 'template' . DS . $template_path . '.php';
	                if (file_exists($file_path)) {
	                    include($file_path);return;
	                }
	            }
	        }
	        $this->_blockData = $block;
	    }else if((is_array($block) && empty($block)) || !is_array($block)){
	        $this->_blockData = $block;
	    }
	}
	
	public function toHtml(){
	    print_r($this->_blockData);
	}
	
	function __destruct() {
			
	}
}
