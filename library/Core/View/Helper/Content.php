<?php

require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_Content extends Core_View_Helper_Abstract
{
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
}
