<?php

class Core_Controller_Plugin_Nav extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$mapper = new Structure_Model_Mapper_Structure();
		$structureTree = $mapper->cachedfetchTree(array(
			$mapper->quoteIdentifier("published") . " = ?"       => 1,
			$mapper->quoteIdentifier("languages_alias") . " = ?" => Zend_Registry::get('lang')
		), array('id', 'structure_id', 'is_url', 'alias', 'languages_alias', 'title', 'url', 'route_name', 'params', 'group_alias', 'category_alias', 'content_alias'), 'ordering');
		
		$pages = $this->_buildNavigation($structureTree);
		$container = new Zend_Navigation($pages);
		Zend_Registry::set('NAVIGATION', $container);
		//var_export($pages);
	}
	
	protected function _buildNavigation($collection)
	{
		$pages = array();
		foreach ($collection as $entity) {
			if ($entity->isUrl == 'YES') {
				$url = explode('/', trim($entity->url, '/'));
				if (strlen($url[0]) != 2 && $url[0] != 'http:') {
					array_unshift($url, $entity->languages_alias);
					$url = '/' . implode('/', $url);
				} else {
					$url = $entity->url;
				}
				
				$active = ($url == $_SERVER['REQUEST_URI']) ? true : false;
				// TODO: set active non mvc links
				
				$page = array(
					'label' => $entity->title,
				    'uri'   => $url,
				    'id'    => $entity->alias,
				    'active'=> $active
				);
			} else {
				$page = array(
					'label'  => $entity->title,
					'route'  => 'contents',
					'id'     => $entity->alias
				);
				
				$params = array();
				if ($entity->groupAlias > 0) {
					$params['group_id'] = $entity->groupAlias;
				}
				if ($entity->categoryAlias > 0) {
					$params['category_id'] = $entity->categoryAlias;
				}
				if ($entity->contentAlias > 0) {
					$params['content_id'] = $entity->contentAlias;
				}
				
				$page['params'] = $params;
			}
			
			if (count($entity->getExtendChilds()) > 0) {
				$page['pages'] = $this->_buildNavigation($entity->getExtendChilds());
			}
			
			$pages[] = $page;
		}
		
		return $pages;
	}
}