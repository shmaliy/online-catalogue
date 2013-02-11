<?php

require_once "Zend/Controller/Router/Route.php";

class Core_Controller_Router_Route_Contents extends Zend_Controller_Router_Route
{
	protected $_groups = array();
	
	protected $_defaults = array();
	
	public function __construct()
	{
		$mapper = new Contents_Model_Mapper_ContentsGroups();
		$groups = $mapper->cachedfetchAll();
		
		foreach ($groups as $group) {
			$this->_groups[$group->alias] = $group;
		}
		
		$this->_defaults = array(
			'lang'           => Zend_Registry::get('lang'),
			'group'          => null,
			'group_alias'    => null,
			'group_id'       => null,
			'category'       => null,
			'category_alias' => null,
			'category_id'    => null,
			'content'        => null,
			'content_alias'  => null,
			'content_id'     => null,
			'module'         => null,
			'controller'     => null,
			'action'         => null,
		);
	}
	
	public function getVersion()
	{
		return 2;
	}
	
	/**
	 * Url patterns:
	 * :lang/:type/:controller/:category_alias/:content_alias - dynamic route
	 * :lang/:type/:group_alias/:content_alias
	 *
	 */	
	public function match($path)
    {
        $return = array();
        
        $contentsMapper   = new Contents_Model_Mapper_Contents();
        $categoriesMapper = new Contents_Model_Mapper_ContentsCategories();
        $groupsMapper     = new Contents_Model_Mapper_ContentsGroups();
        
        $requestUri = trim($path->getPathInfo(), $this->_urlDelimiter);
        $parts      = explode($this->_urlDelimiter, $requestUri);
        //var_export($requestUri);
        //var_export($parts);
        
        if (strlen($parts[0]) != 2) {
        	return false;
        } else {
        	$return['lang'] = $parts[0];
        }
        
        if (count($parts) > 1) {
        	if (array_key_exists($parts[1], $this->_groups)) {
        		$return['module'] = 'contents';
        		
        		$isStatic = ($this->_groups[$parts[1]]->dynamic == 'NO') ? true : false;
        		
        		$return['controller'] = 'static';
        		if (!$isStatic) {
        			$return['controller'] = str_replace('_', '-',$parts[1]);
        		}
        		
        		$return['group']       = $this->_groups[$parts[1]];
        		$return['group_alias'] = $return['group']->alias;
        		$return['group_id']    = $return['group']->id;
        		
        		if (count($parts) > 2) {        			
        			if ($isStatic) {
        				$return['content_alias'] = $parts[2];
        				$return['action'] = 'view';
        				
        				// Load static content item
						$return['content'] = $contentsMapper->getFrontContentByAliasAndGroup($return['group']->id, $return['content_alias'], $return['lang']);
						if (!$return['content']) {
							$return['content_alias'] = urldecode($return['content_alias']);
							$return['content'] = $contentsMapper->getFrontContentByAliasAndGroup($return['group']->id, $return['content_alias'], $return['lang']);
							
							if (!$return['content']) {
								return false;
							}
        				}
        				$return['content_id'] = $return['content']->id;
					} else {
						//return false;
	        			$return['category_alias'] = $parts[2];
	        			
	        			// Load category item
        				$return['category'] = $categoriesMapper->getFrontCatsByAlias($return['group']->id, $return['category_alias'], $return['lang']);        				
        				if (!$return['category']) {
        					//echo "<pre>" . var_export($return, true) . "</pre>";
        					return false;
        				}
        				$return['category_id'] = $return['category']->id;
        				
						if (count($parts) > 3) {
							$return['content_alias'] = $parts[3];
							$return['action'] = 'view';
							
							// Load content item
							$return['content'] = $contentsMapper->getFrontContentByAliasAndGroup($return['group']->id, $return['content_alias'], $return['lang']);
							if (!$return['content']) {
								$return['content_alias'] = urldecode($return['content_alias']);
								$return['content'] = $contentsMapper->getFrontContentByAliasAndGroup($return['group']->id, $return['content_alias'], $return['lang']);
								
								if (!$return['content']) {
									return false;
								}
	        				}
	        				$return['content_id'] = $return['content']->id;
						} else {
							$return['action'] = 'category';
						}
	 				}
       			} else {
        			$return['action'] = 'index';
        		}
		        
		        return $return;
        	}
        }
        
        return false;
    }

    public function assemble($data = array(), $reset = false, $encode = false, $partial = false)
    {
        $contentsMapper   = new Contents_Model_Mapper_Contents();
        $categoriesMapper = new Contents_Model_Mapper_ContentsCategories();
        $groupsMapper     = new Contents_Model_Mapper_ContentsGroups();
        	
        $parts = array();
        
        if (!isset($data['lang']) || strlen($data['lang']) != 2) {
        	$parts[] = Zend_Registry::get('lang');
		} else {
			$parts[] = $data['lang'];
		}
		
		if (isset($data['group_alias']) || isset($data['group_id']) || isset($data['group']) && $data['group'] instanceof Contents_Model_Entity_ContentsGroups) {
			if (isset($data['group'])) {
				$parts[] = $data['group']->alias;
			} else if (!empty($data['group_alias'])) {
				$parts[] = $data['group_alias'];
			} else if (!empty($data['group_id'])) {
				$group = $groupsMapper->findEntity($data['group_id']);
				if (!$group) {
					return;
				}
				
				$parts[] = $group->alias;
			}
			
			$isStatic = $data['group']->dynamic == 'NO' ? true: false;
			
			if (!$isStatic && (isset($data['category_alias']) || isset($data['category_id']) || isset($data['category']) && $data['category'] instanceof Contents_Model_Entity_ContentsCategories)) {
				if (isset($data['category'])) {
					$parts[] = $data['category']->alias;
				} else if (!empty($data['category_alias'])) {
					$parts[] = $data['category_alias'];
				} else if (!empty($data['category_id'])) {
					$category = $categoriesMapper->findEntity($data['category_id']);					
					if ($category) {
						$parts[] = $category->alias;
					}
				}
			}
			
			if (isset($data['content_alias']) || isset($data['content_id']) || isset($data['content']) && $data['content'] instanceof Contents_Model_Entity_Contents) {
				if (isset($data['content'])) {
					$parts[] = $data['content']->alias;
				} else if (!empty($data['content_alias'])) {
					$parts[] = $data['content_alias'];
				} else if (!empty($data['content_id'])) {
					$content = $contentsMapper->findEntity($data['content_id']);
					if ($content) {
						$parts[] = $content->alias;
					}
				}
			}
		}
        
        return trim(implode($this->_urlDelimiter, $parts), $this->_urlDelimiter);
    }
    
    public function getDefaults()
    {
    	return $this->_defaults;
    }
}
