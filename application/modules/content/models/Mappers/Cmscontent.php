<?php

class Content_Model_Mapper_Cmscontent extends Sunny_DataMapper_MapperAbstract
{
	public function getContentList($path)
	{
		$list = array();
		$catMapper = new Content_Model_Mapper_Cmscategories();
		
		$pathA = explode('/', trim($path, '/'));
		
		$parent = 0;
		
		foreach ($pathA as $cat) {
			$category = $catMapper->getCategory($cat, $parent);
			$parent = $category['id'];
		}
		
		//echo $path . '<br />';

		$select = $this->getDbTable()->select();
		$select->setIntegrityCheck(false);
		
		$select->from(
			array(
					"content" => "cmscontent"
			)
		);
		
		$select->where("content.published = 1");
		$select->where("content.parent_id = ?", $parent);
		$select->order('content.ordering');
		
		$cList =  $this->getDbTable()->fetchAll($select, null);
		
		foreach ($cList as $item) {
			$uri = $path . '/' . $item['id'];
			
			if (!empty($item['title_alias'])) {
				$uri = $path . '/' . $item['title_alias'] . '.html';
			}
			
			$list[] = array(
				'label'		=> $item['title'],
				'uri'		=>	$uri,
				'class'		=> 'hidden',
				'active'	=> $_SERVER['REQUEST_URI'] == $uri, 		
			);
		}
		
		return $list;
	}
}