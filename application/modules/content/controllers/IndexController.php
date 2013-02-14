<?php

class Content_IndexController extends Sunny_Controller_Action
{
	public function init()
	{
   
	}
    
    public function indexAction()
    {
        
	}  

	public function seoAction()
	{
		$mapper = new Content_Model_Mapper_Cmscontent();
		 
		$item = $mapper->fetchRow(
				array(
						"title_alias = ?" => 'seo',
						"parent_id = 0",
						"published = 1"
				)
		);
		 
		$this->view->item = $item;
	}
	
	public function lastNewsAction()
	{
		
	}
	
	public function staticAction()
	{
		$request = $this->getRequest();
		$params = $request->getParams();
		
// 		echo '<pre>';
// 		var_export($params);
// 		echo '</pre>';
		
		$parentId = 0;
		if ($params['mode'] == 'cat') {
			$catMapper = new Content_Model_Mapper_Cmscategories();
			$path = explode('/', $params['path']);
			foreach ($path as $cat) {
				$where = array(
					"title_alias = ?" => $cat,
					"parent_id = ?" => $parentId,
					"published = 1",
				);
				$catItem = $catMapper->fetchRow($where);
				
				if(!is_null($catItem)) {
					$parentId = $catItem->id;
				} else {
					break;
				}
			}
		}
		
		
		$mapper = new Content_Model_Mapper_Cmscontent();
		
		$where = array(
			"parent_id = ?" => $parentId,
			"published = 1",
			"title_alias = ?" => $params['alias']		
		);
		
		$item = $mapper->fetchRow($where);
		
		$this->view->item = $item;
		
	}
	
	public function makeRender($params)
	{
		return '../application/modules/' . $params['module'] . '/views/scripts/' . $params['controller']; 
	}
	
	public function dynamicListAction()
	{
		$request = $this->getRequest();
		$params = $request->getParams();
		
// 		echo '<pre>';
// 		var_export($params);
// 		echo '</pre>';
		
		$parentId = 0;
		$this->view->pTitle = '';
		
		$catMapper = new Content_Model_Mapper_Cmscategories();
		$path = explode('/', $params['path']);
		$this->view->path = $params['path'];
		foreach ($path as $cat) {
			$where = array(
					"title_alias = ?" => $cat,
					"parent_id = ?" => $parentId,
					"published = 1",
			);
			$catItem = $catMapper->fetchRow($where);
	
			if(!is_null($catItem)) {
				$parentId = $catItem->id;
				$this->view->pTitle = $catItem->title;
				$this->view->pId = $catItem->id;
				
				// Получить список подкатегорий и вкатить их перед списком контента
				
				
				
			} else {
				break;
			}
		}
				
		$mapper = new Content_Model_Mapper_Cmscontent();
		
		$where = array(
				"parent_id = ?" => $parentId,
				"published = 1",
				"title_alias = ?" => ''
		);
		
		$items = $mapper->fetchAll($where, 'ordering');
		
// 		echo '<pre>';
// 		var_export($path);
// 		echo '</pre>';
		
		$this->view->items = $items;
		$this->view->path = $params['path'];
		
		
		$alternate = $this->makeRender($params) . '/' . $path[0] . '.php3';
// 		echo $alternate;
		
		if (is_file($alternate)) {
			$this->render($path[0]);
		}
		
		
	}
	
	public function dynamicItemAction()
	{
		$request = $this->getRequest();
		$params = $request->getParams();
		$path = explode('/', $params['path']);
		
// 		echo '<pre>';
// 		var_export($params);
// 		echo '</pre>';
		
		$mapper = new Content_Model_Mapper_Cmscontent();
		
		$where = array(
				"id = ?" => $params['id'],
				"published = 1"
		);
		
		$item = $mapper->fetchRow($where);
		
// 		echo '<pre>';
// 		var_export($item);
// 		echo '</pre>';
		
 		$this->view->path = $params['path'];
 		$this->view->item = $item;
				
 		$alternate = $this->makeRender($params) . '/' . $path[0] . '-item.php3';
 		
 		if (is_file($alternate)) {
 			$this->render($path[0] . '-item');
 		}
	}
}