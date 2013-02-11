<?php

/*
* Порядок загрузки:
*
* Bootstrap->__construct()
* Module_Bootstrap->__construct()
* Bootstrap->run()
* 
*/

class Default_Bootstrap extends Zend_Application_Module_Bootstrap
{    
	public function __construct($application)
    {
    	/* Обязательно (иначе не будет работать)!!!! */
    	parent::__construct($application);
    	$this->afterConstruct();
    }
    
    public function afterConstruct()
    {
    	try {
    		$this->setRouter();
    	} catch (Exception $e) {
    		echo $e->getMessage() . '<br /><br />';
    		echo nl2br($e->getTraceAsString());
    		exit();
    	}
    }
    
    public function setRouter()
    {
    	$frontController = Zend_Controller_Front::getInstance();
    	$router = $frontController->getRouter();
    	
    	/* Если есть роут по умолчанию - удаляем */
    	$router->removeDefaultRoutes();
    	
    	/* Роуты для контента */
    	$adapters = Zend_Registry::get('db_adapters');
    	
    	
    	$frontController->setRouter($router);
    }
}
