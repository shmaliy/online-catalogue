<?php

/*
* Порядок загрузки:
*
* Bootstrap->__construct()
* Module_Bootstrap->__construct()
* Bootstrap->run()
*
*/

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	const MULTIDB_REGISTRY_KEY = 'multidb';
	
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
    
    /* Выполняется перед загрузкой модуля */
    public function preModuleConstruct()
    {
    	try {
    		$this->initConfig();
    		$this->initAutoloader();
    		$this->_setAdminConfig();
    		//$this->initSession();
    		$this->initLocalization();
    		$this->initMultiDb();
    		$this->initRouter();
    		$this->_setHelpers();
    		$this->_setDatabases();
    		//$this->initView();
    		$this->_setView();
    	} catch (Exception $e) {
    		echo $e->getMessage() . '<br /><br />';
    		echo nl2br($e->getTraceAsString());
    		exit();
    	}
    }
    
    /* Выполняется после загрузкой модуля */
    public function postModuleConstruct()
    {
    	try {
    		//$this->initView();
    		$this->_setView();
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
    
    protected function _setAdminConfig()
    {
    	// Get system options
    	$options = Zend_Registry::get('options');
    
    	// Load admin config
    	require_once APPLICATION_PATH . '/modules/default/models/Config.php';
    	$adminConfig = new Default_Model_Config();
    	$config = $adminConfig->load();
    	 
    	// Format options to system config
    	$multidb = array(
    			'default' => array(
    					'default' => true,
    					'adapter' => 'PDO_MYSQL',
    					'params'  => array(
    							'profiler' => array(
    									'enabled' => true,
    									'class' => 'Zend_Db_Profiler_Firebug'
    							),
    							'dbname'   => $config['dbname'],
    							'host'     => $config['host'],
    							'username' => $config['username'],
    							'password' => $config['password'],
    							'driver_options' => array(
    									PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'' . $config['encoding'] . '\''
    							)
    					)
    			)
    	);
    	 
    	// Add to system config
    	$options['multidb'] = $multidb;
    	 
    	// Save to registry
    	Zend_Registry::set('options', $options);
    }
    
    protected function _setDatabases()
    {
    	$options = Zend_Registry::get('options');
    	$options = $options['multidb'];
    	 
    	$adapters = array();
    	if (!Zend_Registry::isRegistered(self::MULTIDB_REGISTRY_KEY)) {
    		Zend_Registry::set(self::MULTIDB_REGISTRY_KEY, $adapters);
    	}
    	 
    	// Create adapters
    	$haveDefault = false;
    	foreach ($options as $adapterName => $params) {
    		$params['params']['options']['adapterName'] = $adapterName;
    		$default = (bool) (isset($params['default']) && $params['default']);
    
    		$params['params']['options']['default'] = $default;
    		$db = Zend_Db::factory($params['adapter'], $params['params']);
    
    		$haveDefault = (bool) Zend_Db_Table_Abstract::getDefaultAdapter();
    		if ($default && false === $haveDefault) {
    			Zend_Db_Table_Abstract::setDefaultAdapter($db);
    		} else {
    			$params['default'] = false;
    			echo 1;
    		}
    
    		$adapters[$adapterName] = $db;
    	}
    	 
    	// Store back to registry
    	Zend_Registry::set(self::MULTIDB_REGISTRY_KEY, $adapters);
    	 
    }
    
	public function initAutoloader()
	{
		$autoLoader = Zend_Loader_Autoloader::getInstance();		
		$autoLoader->setFallbackAutoloader(true);
	}    
    
	public function initSession()
	{
		/* Данный метод должен вызываться перед любым использованием сессий */
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
    	/* Настраивать базовые роуты здесь. У модулей есть свои Bootstrap.php */
    	$frontController = Zend_Controller_Front::getInstance();
    	$router = $frontController->getRouter();
        	
    	/* Если есть роут по умолчанию - удаляем */
    	$router->removeDefaultRoutes();
    	
    	/* Роут для главноу страницы */
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
    
//     public function initView()
//     {
// 	    /* Настройка маршрутизатора */
//     	$options = Zend_Registry::get('options');
	    
// 	    /* Установка типа файлов шаблонов */
//     	$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
//         $viewRenderer->setViewSuffix($options['resources']['layout']['viewSuffix']);
        	    
// 	    /* Добавление путей помошников */
//     	//$view = $this->getResource('view');
//     	//$view->addHelperPath('Custom/View/Helper', 'Custom_View_Helper');
//     }
    
    /**
     * Setup custom layout files suffix
     */
    protected function _setView()
    {
    	$options = $this->getOptions();
    	$frontController = Zend_Controller_Front::getInstance();
    	Zend_Registry::set('lang', 'default');
    	
    	// Set templates suffix
    	$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
    	$viewRenderer->setViewSuffix($options['resources']['layout']['viewSuffix']);
    
    	// Add custom view helpers paths
      }
    
    protected function _setHelpers()
    {
    	//$loader = Zend_Controller_Action_HelperBroker::getPluginLoader();
    	//$loader->addPrefixPath('Sunny_Controller_Action_Helper', 'Sunny/Controller/Action/Helper/');
    	//Zend_Controller_Action_HelperBroker::setPluginLoader($loader);
    	 
    	$helper = new Sunny_Controller_Action_Helper_ArrayTrans();
    	Zend_Controller_Action_HelperBroker::addHelper($helper);
    	//Zend_Controller_Action_HelperBroker::getStack()->offsetSet(null, $helper);
    }
}

