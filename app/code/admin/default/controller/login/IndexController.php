<?php
namespace admin\controller\login;
use system\admin\Controller;
class IndexController extends Controller{ //extends Controller
	function indexAction($data=array()){
		$layout = $this->layout();
		$layout->renderLayout('login');
	}
}
