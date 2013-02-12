<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
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
            
        } catch (Exception $e) {
        	echo $e->getMessage();
        }
        
    	parent::run();
    }
    
   public function setPlugins()
	{
		$front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Custom_Controller_Plugin_IEStopper(array('ieversion' => 7)));
            
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

// 	    /*  Многоязычность на главной  */
// 	    $route = new Zend_Controller_Router_Route_Regex(
// 	    	'[a-z]{2}',
// 	    	array(
// 	    		'module' => 'default',
// 	    	    'controller' => 'index',
// 	    	    'action'     => 'index',
// 	    		'lang' => $lang
// 	    	)
// 	    );
// 	    $router->addRoute('index', $route);
// 	    /*-----------------------------*/
	    
// 	    /*  Контактная информация  */
// 	    $route = new Zend_Controller_Router_Route(
// 	    	':lang/contacts',
// 	    	array(
// 	    	  	'module' => 'content',
// 	    	    'controller' => 'new-index',
// 	    	    'action'     => 'contacts',
// 	    		'lang' => $lang,
// 	        	'cat-alias' => 'contacts'
// 	    	)
// 	    );
// 	    $router->addRoute('contacts', $route);
	    
	    
	    
        
	    return $router;
	}
	
	public function setModules()
	{
	    //$modules = new Ext_Modules_Load();
    	//Zend_Registry::set('modules', $modules->getList());
	}
}

