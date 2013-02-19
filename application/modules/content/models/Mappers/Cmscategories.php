<?php

class Content_Model_Mapper_Cmscategories extends Sunny_DataMapper_MapperAbstract
{
	public function makeCatsTree($path, $parent = 0) 
	{
		$cats = array();
		if ($parent == 0) {
			
			$pArray = explode('/', $path);
			
			foreach ($pArray as $cat) {
				$category = $this->getCategory($cat, $parent);
				$parent = $category['id'];
			}
		}
		
		$categories = $this->getCategories($parent);
		
// 		echo '<pre>';
// 		var_export($categories);
// 		echo '</pre>';
			
		if (empty($categories)) {
			return array();
		}
		
		foreach ($categories as $item) {
			$newPath = $path . '/' . 	$item['title_alias'];
			$cats[] = array(
				'label' => $item['title'],
				'uri'   => '/' . $newPath,
				'class' => 'hidden',
				'active'	=> $_SERVER['REQUEST_URI'] == '/' . $newPath,
				'pages'	=> $this->makeCatsTree($newPath, $item['id'])
			);
		}
		
		
		
		
		return $cats;
	}
	
	public function getCategory($alias, $parent = 0)
	{
		$select = $this->getDbTable()->select();
		$select->setIntegrityCheck(false);
		
		$select->from(
			array(
				"cat" => "cmscategories"		
			)		
		);
		
		$select->where("cat.published = 1");
		$select->where("cat.parent_id = ?", $parent);
		$select->where("cat.title_alias = ?", $alias);
		
		return $this->getDbTable()->fetchRow($select, null);
	}
	
	public function getCategories($parent = 0)
	{
		$select = $this->getDbTable()->select();
		$select->setIntegrityCheck(false);
	
		$select->from(
				array(
						"cat" => "cmscategories"
				)
		);
	
		$select->where("cat.published = 1");
		$select->where("cat.parent_id = ?", $parent);
		$select->order('cat.ordering');
		
 		return $this->getDbTable()->fetchAll($select, null);
	}
	
}