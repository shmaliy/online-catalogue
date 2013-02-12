<?php
require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_Link extends Core_View_Helper_Abstract
{
	public function Link() 
	{
		return $this;
	}

	public function makeUrl($entity)
	{
		if ($entity->isUrl == 'YES') {
			$url = explode('/', trim($entity->url, '/'));
			if (strlen($url[0]) != 2 && $url[0] != 'http:') {
				array_unshift($url, $entity->languages_alias);
				return '/' . implode('/', $url);
			} else {
				return $entity->url;
			}
				
			$page = array(
				'label' => $entity->title,
			    'uri'   => $url,
			    'id'    => $entity->alias
			);
		} else {
			$page = array(
				'label'  => $entity->title,
				'route'  => 'contents',
				'id'     => $entity->alias
			);
				
			$groupMapper = new Contents_Model_Mapper_ContentsGroups();
			$categoryMapper = new Contents_Model_Mapper_ContentsCategories();
			$contentsMapper = new Contents_Model_Mapper_Contents();
			
			$params = array();
			if ($entity->groupAlias > 0) {
				$group = $groupMapper->findEntity($entity->groupAlias);
				$params['group_id'] = $group->alias;
			}
			if ($entity->categoryAlias > 0) {
				$category = $categoryMapper->findEntity($entity->categoryAlias);
				$params['category_id'] = $category->alias;
			}
			if ($entity->contentAlias > 0) {
				$content = $contentsMapper->findEntity($entity->contentAlias);
				$params['content_id'] = $content->alias;
			}
				
			array_unshift($params, $entity->languages_alias);
			$page['params'] = $params;
			return '/' . implode('/', $params);
		}
		
		echo '<pre>';
		var_export($page);
		echo '</pre>';
		
		
	}
}