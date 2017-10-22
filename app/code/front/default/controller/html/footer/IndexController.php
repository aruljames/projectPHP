<?php
namespace front\controller\html\footer;
use system\front as system;
class IndexController extends system\Controller{
	function index($data=array()){
		//print_r($data);
		$this->renderPageOnly();
	}
}
