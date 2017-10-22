<?php
namespace system\front;
use system\front\Template;
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
	protected $_head_flag = true;
	protected $_header_flag = true;
	protected $_foot_flag = true;
	protected $_footer_flag = true;
	protected $_head_action = 'index';
	protected $_header_action = 'index';
	protected $_foot_action = 'index';
	protected $_footer_action = 'index';
	protected $_variables = array();
	

	function __construct($_page,$_controller,$_action) {
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
		$this ->_template = new Template($this ->_page,$this ->_controller,$this ->_action);
	}
	
	function renderPage($full_page=true){
		$controller_info["page"] = $this ->_page;
		$controller_info["controller"] = $this ->_controller;
		$controller_info["action"] = $this ->_action;
		$controller_info["data"] = $this ->_variables;
		$controller_infos[]=$controller_info;
		if($full_page && $this ->_head_flag){
			$_className = 'front\\controller\\'.$this ->_head;
			$dispatch = new $_className('html','head',$this ->_head_action);
			call_user_func_array(array($dispatch,$this ->_head_action),$controller_infos);
		}
		if($full_page && $this ->_header_flag){
			$_className = 'front\\controller\\'.$this ->_header;
			$dispatch = new $_className('html','header',$this ->_header_action);
			call_user_func_array(array($dispatch,$this ->_header_action),$controller_infos);
		}
		$this->renderPageOnly();
		if($full_page && $this ->_head_flag){
			$_className = 'front\\controller\\'.$this ->_foot;
			$dispatch = new $_className('html','foot',$this ->_foot_action);
			call_user_func_array(array($dispatch,$this ->_foot_action),$controller_infos);
		}
		if($full_page && $this ->_header_flag){
			$_className = 'front\\controller\\'.$this ->_footer;
			$dispatch = new $_className('html','footer',$this ->_footer_action);
			call_user_func_array(array($dispatch,$this ->_footer_action),$controller_infos);
		}
	}
	
	function renderPageOnly(){
		if(!is_object($this ->_template)){
			$this->createTemplate();
		}
		$this->_template->render();
	}

	function __destruct() {
			
	}

}
