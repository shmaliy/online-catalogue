<?php

class Menu_Model_Mapper_Cmsmenu extends Sunny_DataMapper_MapperAbstract
{
	
	public function makeNavContainer($array, $alias = null, $parent = 0, $level = 0)
	{
		
		$catsMapper = new Content_Model_Mapper_Cmscategories();
		$contMapper = new Content_Model_Mapper_Cmscontent();
		
		$_tree = array();
		$level++;
		
		$current = $_SERVER['REQUEST_URI'];
		
		foreach ($array as &$item) {
			if ($item['parent_id'] == $parent) {
				
				$link = trim($item['link'], '/');
				

				$pages = $this->makeNavContainer($array, null, $item['id'], $level);
				
				if (!strstr($link, '.html') && !preg_match('[0-9]+', $link) && $link != '')
				{
					
					$rcontents = $contMapper->getContentList($item['link']);
					
						
					if (!empty($rcontents)) {
						foreach ($rcontents as $ritem) {
							array_push($pages, $ritem);
						}
					}
					
					$cats = $catsMapper->makeCatsTree($link);
					if (!empty($cats)) {
						foreach ($cats as &$cat) {
							
							$contents = $contMapper->getContentList($cat['uri']);
							
							if (!empty($contents)) {
								$cat['pages'] = $contents;
							}
							
							array_push($pages, $cat);
						}
					}
				}
				
				$class='mainmenu_' . $level;
				
				$_tree[] = array(
						'label'   	=> $item['title'],
						'uri' 	  	=> $item['link'],
						'class'		=> $class,
						'pages'		=> $pages,
						'active'	=> $_SERVER['REQUEST_URI'] == $item['link']
				);
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