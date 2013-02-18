<?php

require 'Core/Application/Bootstrap/Abstract.php';

class Bootstrap extends Core_Application_Bootstrap_Abstract
{	
    
	const MULTIDB_REGISTRY_KEY = 'multidb';
	
	public function run()
    {
        try {
	    	$this->setConfig();	        
	    	$this->setLoader();	    	
	    	$this->setModules(); // merge config with modules config           
	    	$this->setView();
			$this->setPlugins();
	        $this->_setDatabases();	 
	        $router = $this->setRouter();	    	
            $front = Zend_Controller_Front::getInstance();            
            $front->setRouter($router);            
            //$front->registerPlugin(new Ext_Controller_Plugin_ModuleBootstrap, 1);
            Zend_Registry::set('interface', $this->_options['interface']);
            $this->_setNavigation();
            
        } catch (Exception $e) {
        	echo $e->getMessage();
        }
        //Zend_Registry::set('lang', 'default');
    	parent::run();
    }
    
	public function _setNavigation()
	{
		
		
		$mapper = new Menu_Model_Mapper_Cmsmenu();
		$mapper->mainMenu('mainmenu');
	}
	
	public function setPlugins()
	{
		$front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Custom_Controller_Plugin_IEStopper(array('ieversion' => 7)));
        
        $navigation = new Core_Controller_Plugin_Nav(/*$this->getOption('sunny_controller_plugin_auth')*/);
        $front->registerPlugin($navigation);
            
	}
	
    public function setConfig()
    {
        Zend_Registry::set('options', $this->_options);    	
    }
    
    /**
     * 
     */
	public function setLoader()
	{
		$autoLoader = Zend_Loader_Autoloader::getInstance();		
		$autoLoader->setFallbackAutoloader(true);
	}    
    
	/**
     * 
     */
	public function setView()
	{
		// Add custom view helpers paths
		$view = $this->getResource('view');
		$view->addHelperPath('Sunny/View/Helper', 'Sunny_View_Helper');
		$view->addHelperPath('Core/View/Helper', 'Core_View_Helper');
		$view->addHelperPath('Core/Image/View/Helper', 'Core_Image_View_Helper');
		
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setViewSuffix('php3');
				
		$layout = Zend_Layout::getMvcInstance();
		$url = parse_url($_SERVER['REQUEST_URI']);
		$url = $url['path'];
		$url = trim($url, '/');
		$url = explode('/', $url);
		
		
		if($url[0] == 'admin'){
			$layout->setLayout('admin');
		} else {
			$layout->setLayout('layout');
		}
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
	
	
	public function setRouter()
	{
	    $router = new Zend_Controller_Router_Rewrite();
	    //$router->removeDefaultRoutes();

	    $route = new Zend_Controller_Router_Route (
	    	'',
	    	array(
	    		'module' => 'default',
	    	    'controller' => 'index',
	    	    'action'     => 'index',
	    	)
	    );
	    $router->addRoute('index', $route);

	    
	    $router->addRoute(
	    		'dynamic_list',
	    		new Zend_Controller_Router_Route_Regex(
    				'([a-zA-Z\/]+)',
    				array(
    						'module' => 'content',
    						'controller' => 'index',
    						'action' => 'dynamic-list',
    						'path' => '',
    				),
    				array(
    						1 => 'path',
    				),
    				'%s'
	    ));
	    
	    $router->addRoute(
	    		'dynamic_item',
	    		new Zend_Controller_Router_Route_Regex(
    				'([a-zA-Z\/]+)/([0-9]+)',
    				array(
    						'module' => 'content',
    						'controller' => 'index',
    						'action' => 'dynamic-item',
    						'path' => '',
    						'id' => '',
    				),
    				array(
    						1 => 'path',
    						2 => 'id'
    				),
    				'%s/%s'
	    ));
	    
	    $router->addRoute(
	    		'cat_static', 
	    		new Zend_Controller_Router_Route_Regex(
	    			'([a-zA-Z0-9\/]*)/([a-zA-Z0-9]*).html',
		    		array(
		    				'module' => 'content',
		    				'controller' => 'index',
		    				'action' => 'static',
		    				'mode' => 'cat',
		    				'path' => '',
		    				'alias' => ''
		    		),
		    		array(
		    				1 => 'path',
		    				2 => 'alias'
		    		),
	    			'%s/%s'
	    ));
	    
	    $router->addRoute(
	    		'static',
	    		new Zend_Controller_Router_Route_Regex(
    				'([a-zA-Z0-9]*).html',
    				array(
    						'module' => 'content',
    						'controller' => 'index',
    						'action' => 'static',
    						'mode' => 'root',
    						'alias' => ''
    				),
    				array(
    					1 => 'alias'
    				),
    				'%s'
    	));
	    
        
	    return $router;
	}
	
	public function setModules()
	{
	    //$modules = new Ext_Modules_Load();
    	//Zend_Registry::set('modules', $modules->getList());
	}
	
	
	/**
	* Setup custom layout files suffix
	*/
	protected function _setView()
	{
		$options = $this->getOptions();
		
		// Add custom view helpers paths
		$view = $this->getResource('view');
		$view->addHelperPath('Sunny/View/Helper', 'Sunny_View_Helper');
		$view->addHelperPath('Core/View/Helper', 'Core_View_Helper');
		$view->addHelperPath('Core/Image/View/Helper', 'Core_Image_View_Helper');
		
		// Set templates suffix
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer->setViewSuffix($options['resources']['layout']['viewSuffix']);
	}
}

