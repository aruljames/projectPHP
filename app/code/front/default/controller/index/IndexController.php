<?php
namespace front\controller\index;
use system\front\Controller;
class IndexController extends Controller{ //extends Controller
	function indexAction($data=array()){
		//echo "<br> Index Controller";
		$obj = new home;
		$obj->indexAction();
		$model = $this->loadModel("home\home");
		echo $model->sample();
		$this->renderPage();
	}
}
