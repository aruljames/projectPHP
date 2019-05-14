<?php
namespace system\front;
class Model {
	
	protected $variables = array();
	
	function __construct() {
		
	}
	
	public function renderTemplate($includePath){
            ob_start();
                include($includePath);
                $template = ob_get_contents();
            ob_end_clean();
            return $template;
	}
	
	function __get($name){
        if (array_key_exists($name, $this->variables)) {
            return $this->variables[$name];
        }
    }
    
    function __set($name,$value) {
        $this->variables[$name] = $value;
    }

	function __destruct() {
	}
}
