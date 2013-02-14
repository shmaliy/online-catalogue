<?php

require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_Content extends Core_View_Helper_Abstract
{
	private $_catList = array();
	
	public function content()
	{
		return $this;
	}
	
	public function subcategories($curId, $path = '', $render = null)
	{
		$crender = 'subcategories.php3';
		if (!is_null($render)) {
			$crender = $render . '.php3';
		}
		
// 		echo $curId;
		
		$cMapper = new Content_Model_Mapper_Cmscategories();
		$subs = $cMapper->fetchAll(
			array(
				"parent_id = ?" => $curId,
				"published = 1"
			),
			'ordering'
		);
		
// 		echo '<pre>';
// 		var_export($subs);
// 		echo '</pre>';
		
		$this->view->subs = $subs;
		$this->view->path = $path;
		
		return $this->view->render($crender);
	}
	
	public function makeCatTree($parent = 0, $alias = null)
	{
		$where = array();
		if ($parent == 0) {
			$where['title_alias = ?'] = $alias;
		}
	
		$where['parent_id = ?'] = $parent;
		$where[] = 'published = 1';
	
		$mapper = new Content_Model_Mapper_Cmscategories();
		$items = $mapper->fetchAll(
				$where,
				'ordering'
		);
	
		foreach($items as $key=>$item) {
			$item->setExtend($key, $this->makeCatTree($item->id));
		}
	
		return $items;
	}
	
	public function makeCats($parent = 0, $alias = null, $path = '')
	{
		$where = array();
		if ($parent == 0) {
			$where['title_alias = ?'] = $alias;
		}
	
		$where['parent_id = ?'] = $parent;
		$where[] = 'published = 1';
	
		$mapper = new Content_Model_Mapper_Cmscategories();
		$items = $mapper->fetchAll(
				$where,
				'ordering'
		);
	
		foreach($items as $key=>$item) {
			$this->_catList[$item->id] = array(
				"id" => $item->id,
				"path" => $path . '/' . $item->titleAlias	
			);
			$this->makeCats($item->id, null, $path . '/' . $item->titleAlias);
		}
	
		return $items;
	}
	
	public function lastNews($rootAlias = 'news')
	{
		
		$cMapper = new Content_Model_Mapper_Cmscontent();
		
		$catList = $this->makeCats(0, $rootAlias);
		
// 		echo '<pre>';
// 		var_export($this->_catList);
// 		echo '</pre>';
		
		$list = array();
		foreach ($this->_catList as $cat) {
			$list[] = $cat['id'];
		}
		
// 		echo '<pre>';
// 		var_export($list);
// 		echo '</pre>';
		
		$news = $cMapper->fetchAll(
			array(
				"parent_id in (?)" => $list,
				"published = 1"
			),
			'created desc',
			4	
		);
		
// 		echo '<pre>';
// 		var_export($news);
// 		echo '</pre>';
		
		$this->view->news = $news;
		$this->view->cats = $this->_catList;
		
		return $this->view->render('last-news.php3');
	}
}
