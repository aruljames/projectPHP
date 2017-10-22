<?php
namespace front\index;
use system\front as system;
class HomeController extends system\Controller{ //extends Controller
	function indexAction(){
		echo "<br> Index Controller";
		$obj = new newobj;
		$obj->indexAction();
	}
}
