<?php
namespace front\controller\html\foot;
use system\front as system;
class IndexController extends system\Controller{
	function index($data=array()){
		//print_r($data);
		$this->renderPageOnly();
	}
}