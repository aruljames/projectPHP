<?php
namespace admin\controller\index;
use system\admin\Controller;
class IndexController extends Controller{ //extends Controller
	function indexAction($data=array()){
		$layout = $this->layout();
		$layout->renderLayout();
	}
}
