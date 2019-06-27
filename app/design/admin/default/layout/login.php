<?php
$this->getBlock('head')->includeAsset('css','admin/login.css');
$this->getBlock('header')->getLayout('html/empty');
$this->getBlock('footer')->getLayout('html/empty');
$this->getBlock()->setTemplate('login/index');
$this->renderLayout('html/page');
