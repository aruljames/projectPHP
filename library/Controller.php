<?php
namespace lib;
class Controller {

	protected $_model;
	protected $_controller;
	protected $_action;
	protected $_template;

	function __construct() {
		echo "<br> Lib Controller";
	}

	function set($name,$value) {
		$this->_template->set($name,$value);
	}

	function __destruct() {
			
	}

}
