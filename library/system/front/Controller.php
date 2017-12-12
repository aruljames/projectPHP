<?php
namespace system\front;
class Controller {

	protected $_model;
	protected $_page;
	protected $_controller;
	protected $_action;
	protected $_template;
	protected $_head = 'html\\head\\indexController';
	protected $_header = 'html\\header\\indexController';
	protected $_foot = 'html\\foot\\indexController';
	protected $_footer = 'html\\footer\\indexController';
	protected $_headFlag = true;
	protected $_headerFlag = true;
	protected $_footFlag = true;
	protected $_footerFlag = true;
	protected $_headAction = 'index';
	protected $_headerAction = 'index';
	protected $_footAction = 'index';
	protected $_footerAction = 'index';
	protected $_variables = array();
	

	function __construct($_page=null,$_controller=null,$_action=null) {
	    if(!$_page){
	        $_page = "index";
	    }
	    if(!$_controller){
	        $_controller = "index";
	    }
	    if(!$_action){
	        $_action = "index";
	    }
		$this ->_page = $_page;
		$this ->_controller = $_controller;
		$this ->_action = $_action;
	}

	function set($name,$value) {
		$this->_template->set($name,$value);
	}
	function loadModel($model_name = null){
		if(!$model_name = trim($model_name)){
			$model_name = $this ->_controller;
		}
		$model_array = explode("\\",$model_name);
		if(sizeof($model_array)==1){
			$model_class = 'front\\model\\'.$this ->_page.'\\'.$model_name;
		}else{
			$model_class = 'front\\model\\'.$model_name;
		}
		$model = new $model_class;
		return $model;
	}
	
	function createTemplate(){
	    $this ->_template = new \system\front\Template($this ->_page,$this ->_controller,$this ->_action);
	}
	
	function renderPage($full_page=true){
		$controller_info["page"] = $this ->_page;
		$controller_info["controller"] = $this ->_controller;
		$controller_info["action"] = $this ->_action;
		$controller_info["data"] = $this ->_variables;
		$controller_infos[]=$controller_info;
		$template = "";
		if($full_page && $this ->_head_flag){
		    $template .= $this->getPageHtml($this ->_head,'html','head',$this ->_head_action,$controller_infos);
		}
		if($full_page && $this ->_header_flag){
		    $template .= $this->getPageHtml($this ->_header,'html','header',$this ->_header_action,$controller_infos);
		}
		ob_start();
		$this->renderPageOnly();
		$body = ob_get_contents();
		ob_end_clean();
		$template .= $body;
		if($full_page && $this ->_head_flag){
		    $template .= $this->getPageHtml($this ->_foot,'html','foot',$this ->_foot_action,$controller_infos);
		}
		if($full_page && $this ->_header_flag){
		    $template .= $this->getPageHtml($this ->_footer,'html','footer',$this ->_footer_action,$controller_infos);
		}
		print $template;
	}
	
	function renderPageOnly(){
		if(!is_object($this ->_template)){
			$this->createTemplate();
		}
		$this->_template->render();
	}
	
	function getPageHtml($controller_name,$page='index',$class='index',$action='index',$data=array()){
	    ob_start();
	    $_className = 'front\\controller\\'.$controller_name;
	    $dispatch = new $_className($page,$class,$action);
	    call_user_func_array(array($dispatch,$action),$data);
	    $contents = ob_get_contents();
	    ob_end_clean();
	    return $contents;
	}
	
	function renderLayout($layoutName=null){
	    
	    
	}

	function __destruct() {
			
	}

}
