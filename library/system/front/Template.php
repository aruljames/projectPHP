<?php
namespace system\front;
class Template {

	protected $variables = array();
	protected $blocks = array();
	protected $_page;
	protected $_controller;
	protected $_action;
	protected $_template_path;


	function __construct($layout = 'default') {
	    $this->_page = \PPHP::session('core')->page;
	    $this->_controller = \PPHP::session('core')->controller;
	    $this->_action = \PPHP::session('core')->action;
		$this->_template_path = $this->_page.'\\'.$this->_controller.'\\'.$this->_action;
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
	
	function getHtml($class,$action){
	    
	}
	
	function getTemplate($template_name = null,$data=array()){
	    if($template_name == null){$template_name = 'index';}
	    $input_template_array = explode('\\', $template_name);
	    if($input_template_array[0]){
	        $template_path_array[0]=$this->_page;
	        $template_path_array[1]=$this->_controller;
	        $action_array = explode("\\", $this->_action);
	        foreach($action_array as $action){
	            $template_path_array[] = $action;
	        }
	        $input_template_array = array_values(array_filter($input_template_array));
    	    $i = sizeof($template_path_array)-1;
    	    if(sizeof($input_template_array) == 1){
    	        $template_path_array[$i] = $input_template_array[0];
    	    }else{
    	        $i = 2;
        	    foreach($input_template_array as $input_template){
        	        $template_path_array[$i] = $input_template;
        	        $i++;
        	    }
    	    }
	    }else{
	        $template_path_array = array_filter($input_template_array);
	    }
	    $template_path = implode("\\", $template_path_array);
	    /*if($this->_template_path != $template_path){
            ob_start();
            $this->render($template_path,$data);
            $template = ob_get_contents();
            ob_end_clean();
	    }else{
	        $template = "";
	    }*/
	    ob_start();
	    $this->render($template_path,$data);
	    $template = ob_get_contents();
	    ob_end_clean();
        return $template;
	}
	
	function printTemplate($template_name = null,$data=array()){
	    $template = $this->getTemplate($template_name,$data);
	    print_r($template);
	}

	/** Display Template **/

	function render($template_path = null,$data=array()) {
	    if($template_path == null){$template_path = $this->_template_path;}
	    $this->setValues($data);
		//extract($this->variables);
		$codePools = array('default');
		foreach($codePools as $codePool){
		    $file_path = ROOT . DS . 'app' . DS . 'code' . DS . 'front' . DS . $codePool . DS . 'view' . DS . 'template' . DS . $template_path . '.php';
			//echo $file_path."<br>";
			if (file_exists($file_path)) {
				include($file_path);return;
			}
		}
		foreach($codePools as $codePool){
		    $file_path = ROOT . DS . 'app' . DS . 'design' . DS . 'front' . DS . $codePool . DS . 'template' . DS . $template_path . '.php';
			//echo $file_path."<br>";
			if (file_exists($file_path)) {
				include($file_path);return;
			}
		}
    }
    function printPage($pathInfo = null,$data = array()){
        if($pathInfo){
            callHook(getActionPath($pathInfo),$data);
        }else{
            echo "";
        }
    }
    
    function renderLayout($layout='default'){
        $codePools = array('default');
        foreach($codePools as $codePool){
            $file_path = ROOT . DS . 'app' . DS . 'code' . DS . 'front' . DS . $codePool . DS . 'view' . DS . 'layout' . DS . $layout . '.php';
            //echo $file_path."<br>";
            if (file_exists($file_path)) {
                include($file_path);return;
            }
        }
        foreach($codePools as $codePool){
            $file_path = ROOT . DS . 'app' . DS . 'design' . DS . 'front' . DS . $codePool . DS . 'layout' . DS . $layout . '.php';
            //echo $file_path."<br>";
            if (file_exists($file_path)) {
                include($file_path);return;
            }
        }
    }
    
    function setBlock($block = 'default',$data = ''){
        $this->blocks[$block] = $data;
	}
	
	function getBlock($block = 'content'){
		if (array_key_exists($block, $this->blocks)){
            return $this->blocks[$block];
        }else{
			$blockObject = new \system\front\Block($block);
			$this->blocks[$block] = $blockObject;
			return $blockObject;
		}
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
