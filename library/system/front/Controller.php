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
	    \PPHP::session('core')->page= $_page;
	    \PPHP::session('core')->controller= $_controller;
	    \PPHP::session('core')->action= $_action;
		$this ->_page = $_page;
		$this ->_controller = $_controller;
		$this ->_action = $_action;
		$this->createTemplate();
	}
	public function createTemplate($layout = 'default'){
	    $this ->_template = new \system\front\Template($layout);
	}
	public function layout($layout = 'default'){
	    if(!is_object($this ->_template)){
	        $this->createTemplate($layout);
	    }
	    return $this->_template;
	}
// Functions to set data in memory start///
	function set($name,$value) {
	    if(!is_object($this ->_template)){
	        $this->createTemplate();
	    }
		$this->_template->set($name,$value);
	}
	function setData($name,$value) {
	    if(!is_object($this ->_template)){
	        $this->createTemplate();
	    }
	    $this->_template->set($name,$value);
	}
	function __set($name, $value) {
	    if(!is_object($this ->_template)){
	        $this->createTemplate();
	    }
	    $this->_template->set($name,$value);
	}
	// Functions to set data in memory end///
	function loadModel($modelName = null){
		if(!$modelName = trim($modelName)){
			$modelName = $this ->_controller;
		}
		$modelArray = explode("\\",$modelName);
		if(sizeof($modelArray)==1){
			$modelClass = 'front\\model\\'.$this ->_page.'\\'.$modelName;
		}else{
			$modelClass = 'front\\model\\'.$modelName;
		}
		$model = new $modelClass;
		return $model;
	}
	
	function renderPage($fullPage=true){
		$controllerInfo["page"] = $this ->_page;
		$controllerInfo["controller"] = $this ->_controller;
		$controllerInfo["action"] = $this ->_action;
		$controllerInfo["data"] = $this ->_variables;
		$controllerInfos[]=$controllerInfo;
		$template = "";
		if($fullPage && $this ->_headFlag){
		    $template .= $this->getPageHtml($this ->_head,'html','head',$this ->_headAction,$controllerInfos);
		}
		if($fullPage && $this ->_headerFlag){
		    $template .= $this->getPageHtml($this ->_header,'html','header',$this ->_headerAction,$controllerInfos);
		}
		ob_start();
		$this->renderPageOnly();
		$body = ob_get_contents();
		ob_end_clean();
		$template .= $body;
		if($fullPage && $this ->_headFlag){
		    $template .= $this->getPageHtml($this ->_foot,'html','foot',$this ->_footAction,$controllerInfos);
		}
		if($fullPage && $this ->_headerFlag){
		    $template .= $this->getPageHtml($this ->_footer,'html','footer',$this ->_footerAction,$controllerInfos);
		}
		print $template;
	}
	
	function renderPageOnly(){
		if(!is_object($this ->_template)){
			$this->createTemplate();
		}
		$this->_template->render();
	}
	
	function getPageHtml($controllerName,$page='index',$class='index',$action='index',$data=array()){
	    ob_start();
	    $_className = 'front\\controller\\'.$controllerName;
	    $dispatch = new $_className($page,$class,$action);
	    call_user_func_array(array($dispatch,$action),$data);
	    $contents = ob_get_contents();
	    ob_end_clean();
	    return $contents;
	}
	
	function renderLayout($layout='default'){
	    if(!is_object($this ->_template)){
	        $this->createTemplate();
	    }
	    $this->_template->renderLayout($layout);
	}
	
	function setBlock($block = 'default',$data = ''){
	    $this->_template->setBlock($block,$data);
	}
	
	function __destruct() {
			
	}

}
