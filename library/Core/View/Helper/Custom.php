<?php

require_once "Core/View/Helper/Abstract.php";


class Core_View_Helper_Custom extends Core_View_Helper_Abstract
{
	public function custom()
	{
		return $this;
	}
	
	public function topMenu($alias = null)
	{
		$menuMapper = new Menu_Model_Mappers_CmsMenu();
		
		$where = null;
		if (!is_null($alias)) {
			$where = array('title_alias => ?' => $alias);
		}
		
		$items = $menuMapper->fetchTree($where, array('parent_id'), 'ordering');
		
		echo '<pre>';
		var_export($items);
		echo '</pre>';
	}
}
