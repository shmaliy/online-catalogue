<?php

class Default_Model_Config
{
	/**
	 * Config file path (relative to APPLICATION_PATH)
	 * 
	 * @var string
	 */
	protected $_configPath = 'configs/adminconfig.ini';
	
	/**
	 * Setup custom config path
	 * 
	 * @param string $path
	 * @throws Exception
	 */
	public function setConfigPath($path)
	{
		if (!is_string($path)) {
			$type = gettype($path);
			if ($type == 'object') {
				$type = get_class($path) . ' object';
			}
			
			throw new Exception("Config path must be a string, " . $type . ' given', 500);
		}
		
		$path = trim($path, DIRECTORY_SEPARATOR);
		$this->_configPath = $path;
	}
	
	/**
	 * Get current config path
	 * 
	 * @return string
	 */
	public function getConfigPath()
	{
		return $this->_configPath;
	}
	
	/**
	 * Save config options to config file
	 * 
	 * @param array $options
	 */
	public function save(array $options)
	{
		// Initialize config objects
		$writer = new Zend_Config_Writer_Ini();
		$config = new Zend_Config($options);
		
		// Save config to file
		$writer->setConfig($config);
		$writer->setFilename(APPLICATION_PATH . DIRECTORY_SEPARATOR . $this->getConfigPath());
		$writer->write();		
	}
	
	/**
	 * Load config file
	 * 
	 * @return array
	 */
	public function load()
	{
// 		$config = new Zend_Config_Ini(APPLICATION_PATH . DIRECTORY_SEPARATOR . $this->getConfigPath());
// 		return $config->toArray();
	}
	
	// TODO: demo login use config login and pass/ not demo from db
}