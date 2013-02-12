<?php

class Core_Controller_Plugin_ContentsRoute extends Zend_Controller_Plugin_Abstract
{
	public function routeStartup(Zend_Controller_Request_Abstract $request)
	{
		$router = Zend_Controller_Front::getInstance()->getRouter();
		
		$route = new Core_Controller_Router_Route_Contents();
		$router->addRoute('contents', $route);
	}
}
