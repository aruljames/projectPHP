<?php
namespace admin\controller\login;
use system\admin\Controller;
class IndexController extends Controller{ //extends Controller
	function indexAction($data=array()){
		if(isset($_POST['login']) && isset($_POST['password'])){
			$userTable = \PPHP::tableModel('users');
			$userTable->loadByField('user_name',$_POST['login']);
			$userData = $userTable->getAll();
			if (password_verify($_POST['password'], $userData['password'])) {
				\PPHP::redirect('admin');
			}else{
				\PPHP::setMessage(\PPHP::Translate('Invalid username or password'));
			}
		}
		$layout = $this->layout();
		$layout->renderLayout('login');
	}
}
