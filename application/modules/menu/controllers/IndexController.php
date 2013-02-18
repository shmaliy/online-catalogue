<?php

class Menu_IndexController extends Sunny_Controller_Action
{

	public function init()
 	{
   
	}
    
	public function makeMenuTree($parent = 0, $alias = null)
	{
		$where = array();
		if ($parent == 0) {
			$where['title_alias = ?'] = $alias;
		}
		
		$where['parent_id = ?'] = $parent;
		$where[] = 'published = 1';
		
		$mapper = new Menu_Model_Mapper_Cmsmenu();
		$items = $mapper->fetchAll(
				$where,
				'ordering'
		);
		
		foreach($items as $key=>$item) {
			$item->setExtend($key, $this->makeMenuTree($item->id));
		}
		
		return $items;
	}
	
	
	
	
	
    public function indexAction()
    {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	
    	$where = array();
    	$where[] = 'published = 1';
    	$mapper = new Menu_Model_Mapper_Cmsmenu();
    	$items = $mapper->fetchAll(
    			$where,
    			'ordering'
    	);
    	
    	foreach ($items as $item) {
    		$page[] = array(
    				'label'   => $item->title,
    				'uri' 	  => $item->link
    		);
    	}
    	
    	$container = new Zend_Navigation($page);
       
//     	echo '<pre>';
// 		var_export($page);
// 		echo '</pre>';
		$this->view->container = $container;
		$this->view->tree = $this->makeMenuTree(0, 'mainmenu');
	}   
}