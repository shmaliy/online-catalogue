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
       
//     	echo '<pre>';
// 		var_export($this->makeMenuTree(0, 'mainmenu'));
// 		echo '</pre>';
		
		$this->view->tree = $this->makeMenuTree(0, 'mainmenu');
	}   
}