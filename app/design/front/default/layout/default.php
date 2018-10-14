<?php 
//$this->getBlock()->setLayout('new/alternative');
$layout = $this->getBlock()->getLayout('new/alternative');
//$layout->getBlock()->setModel('html/header')->setTemplate('html/header');
$this->renderLayout('html/page');
?>
