<?php

class Menu_Model_Mapper_Cmsmenu extends Sunny_DataMapper_MapperAbstract
{
	
	public function makeNavContainer($array, $alias = null, $parent = 0, $level = 0)
	{
// 		if ($parent == 0) {
// 			foreach ($array as $item) {
// 				if ($item['title_alias'] == $alias) {
// 					$parent = $item['id'];
// 					break;
// 				}
// 			}
// 		}
		
		$_tree = array();
		$level++;
		
		$current = $_SERVER['REQUEST_URI'];
		
		
		foreach ($array as $item) {
			if ($item['parent_id'] == $parent) {
				
				$pages = $this->makeNavContainer($array, null, $item['id'], $level);
				$class='mainmenu_' . $level;
				
							
				if (!empty($pages)) {
					$_tree[] = array(
						'label'   	=> $item['title'],
						'uri' 	  	=> $item['link'],
						'class'		=> $class,
						'pages'		=> $pages,
						'active'	=> $_SERVER['REQUEST_URI'] == $item['link']
					);
				} else {
					$_tree[] = array(
						'label'   	=> $item['title'],
						'uri' 	  	=> $item['link'],
						'class'		=> $class,
						'active'	=> $_SERVER['REQUEST_URI'] == $item['link']
							
					);
				}
				
				
			}
		}
		
		return $_tree;
	}
	
	public function mainMenu($alias = null)
	{
		$select = $this->getDbTable()->select();
		$select->setIntegrityCheck(false);
		
		$select->from(
			array('menu' => 'cmsmenu')		
		);
		
		$select->where('menu.published = 1');
		
		$select->order('menu.ordering');
		
		$list = $this->getDbTable()->fetchAll($select, null);
		
// 		echo '<pre>';
// 		var_export($list);
// 		echo '</pre>';
		
// 		echo '<pre>';
// 		var_export($this->makeNavContainer($list, $alias));
// 		echo '</pre>';
		
		$container = $this->makeNavContainer($list, $alias);
		$container = new Zend_Navigation($container);
		Zend_Registry::set('nav_container', $container);
		
		return $container;
	}
	
}