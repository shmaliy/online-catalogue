<?php

/*
* ������� ��������:
*
* Bootstrap->__construct()
* Module_Bootstrap->__construct()
* Bootstrap->run()
*
*/

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function __construct($application)
    {
    	parent::__construct($application);
    	$this->preModuleConstruct();
    }
	
	public function run()
    {
    	$this->postModuleConstruct();
    	parent::run();
    }
    
    /* ����������� ����� ��������� ������ */
    public function preModuleConstruct()
    {
    	try {
    		$this->initConfig();
    		$this->initAutoloader();
    		//$this->initSession();
    		$this->initLocalization();
    		$this->initMultiDb();
    		$this->initRouter();
    		$this->initView();
    	} catch (Exception $e) {
    		echo $e->getMessage() . '<br /><br />';
    		echo nl2br($e->getTraceAsString());
    		exit();
    	}
    }
    
    /* ����������� ����� ��������� ������ */
    public function postModuleConstruct()
    {
    	try {
    		$this->initView();
    	} catch (Exception $e) {
    		echo $e->getMessage() . '<br /><br />';
    		echo nl2br($e->getTraceAsString());
    		exit();
    	}
    }
    
    public function initConfig()
    {
    	Zend_Registry::set('options', $this->_options);
    }
    
    
	public function initAutoloader()
	{
		$autoLoader = Zend_Loader_Autoloader::getInstance();		
		$autoLoader->setFallbackAutoloader(true);
	}    
    
	public function initSession()
	{
		/* ������ ����� ������ ���������� ����� ����� �������������� ������ */
		$frontController = Zend_Controller_Front::getInstance();
		$request = $frontController->getRequest();
		
		if (null === $request) {
			$request = new Zend_Controller_Request_Http();
			$frontController->setRequest($request);
		}
		
		$sid = $request->getParam('PHPSESSID');
		if (!empty($sid)) {
			Zend_Session::setId($sid);
		}
	}
    
    public function initLocalization()
    {
    	$localization = new Zend_Session_Namespace('Localization');
    	if (!isset($localization->language)) {
    		$localization->language = 'ru';
    	}
    }
    
    public function initMultiDb()
    {
	   	$adapters = array();
    	$options = Zend_Registry::get('options');
    	
    	if (!is_array($options['resources']['db'])) { return; }    	
    	foreach ($options['resources']['db'] as $connectionName => $adapterOptions) {
    		$adapters[$connectionName] = Zend_Db::factory(
    			$adapterOptions['adapter'], 
    			$adapterOptions['params']
    		);
    	}
    	
    	if (!empty($adapters)) {
    		Zend_Registry::set('db_adapters', $adapters);
    	}
    }
    
    public function initRouter()
    {
    	/* ����������� ������� ����� �����. � ������� ���� ���� Bootstrap.php */
    	$frontController = Zend_Controller_Front::getInstance();
    	$router = $frontController->getRouter();
        	
    	/* ���� ���� ���� �� ��������� - ������� */
    	$router->removeDefaultRoutes();
    	
    	/* ���� ��� ������� �������� */
    	$router->addRoute('default', new Zend_Controller_Router_Route_Static(
   	    	'',
   			array(
    			'module' => 'default',
    			'controller' => 'index',
    			'action' => 'index'
   			)
   		));
    	
    	$frontController->setRouter($router);
    }
    
    public function initView()
    {
	    /* ��������� �������������� */
    	$options = Zend_Registry::get('options');
	    
	    /* ��������� ���� ������ �������� */
    	$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setViewSuffix($options['resources']['layout']['viewSuffix']);
	    	    
	    /* ���������� ����� ���������� */
    	//$view = $this->getResource('view');
    	//$view->addHelperPath('Custom/View/Helper', 'Custom_View_Helper');
    }
}

