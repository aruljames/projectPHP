<?php
namespace system\front;
class Block {
    protected $_blockData;
    protected $_blockname;
	protected $_page;
	protected $_layout;
	protected $_layoutName;
    protected $_controller;
    protected $_action;
    protected $_template_path;
    protected $_model = null;
    protected $_template = null;
    protected $_modelData = null;
    
    function __construct($block='content',$layout = 'default') {
        $this->_page = \PPHP::session('core')->page;
        $this->_controller = \PPHP::session('core')->controller;
        $this->_action = \PPHP::session('core')->action;
		$this->_blockname = $block;
		$this->_layoutName = $layout;
	    if(is_array($block) && !empty($block)){
	        if(isset($block['class'])){
	            
	        }else if(isset($block['template'])){
	            $codePools = array('default');
	            $template_path = $this->_template_path;
	            foreach($codePools as $codePool){
	                $file_path = _ROOT . DS . 'app' . DS . 'code' . DS . 'front' . DS . $codePool . DS . 'view' . DS . 'template' . DS . $template_path . '.php';
	                if (file_exists($file_path)) {
	                    include($file_path);return;
	                }
	            }
	            foreach($codePools as $codePool){
	                $file_path = _ROOT . DS . 'app' . DS . 'design' . DS . 'front' . DS . $codePool . DS . 'template' . DS . $template_path . '.php';
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

	public function setLayout($layout = null){
		if($layout){
			$this->_layout = $layout;
		}
		return $this;
	}
	public function getLayout($layout = null){
		if(!$layout){
			$layout = $this->_layoutName;
		}
		return $this->_layout = new \system\front\Layout($layout);
	}
	
	public function setModel($model){
		$this->_model = $model;
		return $this;
	}
	
	public function setTemplate($template){
		$this->_template = $template;
		$template = array_filter(explode('/',$template));
		foreach($template as $template){
			$templatePathArray[] = $template;
		}
		$this->_template_path = implode(DS,$templatePathArray);
		return $this;
	}
	
	public function toHtml(){
	    print_r($this->getHtml());
	}
	
	public function getHtml(){
		if(!is_object($this ->_layout)){
			if($this->_model == null || !trim($this->_model)){
				$this->_model = $this->_controller.'/'.$this->_action;
			}
			if($this->_template_path == null || !trim($this->_template_path)){
				$this->_template_path = $this->_page.'/'.$this->_controller.'/'.$this->_action;
			}
			$model = str_replace('/','\\',$this->_model);
			$className = '\front\model\\'.$model;
			$obj = new $className;
			$this->_modelData = $obj;
			
			$includePath = '';
			$codePools = array('default');
			$template_path = $this->_template_path;
			foreach($codePools as $codePool){
				$file_path = _ROOT . DS . 'app' . DS . 'code' . DS . 'front' . DS . $codePool . DS . 'view' . DS . 'template' . DS . $template_path . '.php';
				if (file_exists($file_path)) {
					$includePath = $file_path;break;
				}
			}
			foreach($codePools as $codePool){
				$file_path = _ROOT . DS . 'app' . DS . 'design' . DS . 'front' . DS . $codePool . DS . 'template' . DS . $template_path . '.php';
				if (file_exists($file_path)) {
					$includePath = $file_path;break;
				}
			}
			if($includePath)
				return $obj->renderTemplate($includePath);
		}else{
			$this ->_layout->renderLayout();
		}
	}
	
	function __destruct() {
			
	}
}
