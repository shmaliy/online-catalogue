<?php

class Core_Controller_Plugin_Nav extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$mapper = new Menu_Model_Mapper_Cmsmenu();
		$container = $mapper->mainMenu('mainmenu');
		Zend_Registry::set('NAVIGATION', $container);
	}
}