<?php
namespace front\controller\html\header;
use system\front as system;
class IndexController extends system\Controller{
	function index($data=array()){
		//echo "<br> Header Index Controller";
		$this->renderPageOnly();
	}
}
