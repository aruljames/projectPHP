<?php
namespace system\front;
class Template {

	protected $variables = array();
	protected $_page;
	protected $_controller;
	protected $_action;
	protected $_template_path;

	function __construct($_page,$_controller,$_action) {
		$this->_page = $_page;
		$this->_controller = $_controller;
		$this->_action = $_action;
		$this->_template_path = $_page.'\\'.$_controller.'\\'.$_action;
		
		//echo "<br>".$this->_page. " " . $_controller ." Template";
	}

	/** Set Variables **/

	function set($name,$value) {
		$this->variables[$name] = $value;
	}

	/** Display Template **/

    function render() {
		extract($this->variables);
		$codePools = array('default');
		foreach($codePools as $codePool){
			$file_path = ROOT . DS . 'app' . DS . 'code' . DS . 'front' . DS . $codePool . DS . 'view' . DS . $this->_template_path . '.php';
			//echo $file_path."<br>";
			if (file_exists($file_path)) {
				include($file_path);return;
			}
		}
		foreach($codePools as $codePool){
			$file_path = ROOT . DS . 'app' . DS . 'design' . DS . 'front' . DS . $codePool . DS . $this->_template_path . '.php';
			//echo $file_path."<br>";
			if (file_exists($file_path)) {
				include($file_path);return;
			}
		}
    }

}
