<?php
namespace front\controller\index;
use system\front\Controller;
class IndexController extends Controller{ //extends Controller
	function indexAction($data=array()){
		$layout = $this->layout();
		//$header = $this->getBlock('header');
		//$header = setTemplate();
	    $layout->renderLayout();
		//echo "Index Controller";
		$this->set("name","Arul");
		$this->age = "27";
		$obj = new home;
		//$obj->indexAction();
		//$model = $this->loadModel("home\home");
		//echo $model->sample();
		//$this->setBlock('pageBody','my message');
		//$this->renderLayout();
		//$this->renderPage();
	}
}
