<?php
namespace front\controller\home;
use system\front\Controller;
class indexController extends Controller{ //extends Controller
	function indexAction($data){
		print_r($data);
		echo "<br> Home Index Controller";
	}
}
