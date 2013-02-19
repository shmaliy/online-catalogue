<?php

require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_Seo extends Core_View_Helper_Abstract 
{
	public function seo()
	{
		$path = $_SERVER['REQUEST_URI'];
		$path = trim($path, '/');
		//return $path;
		
		$array = explode('/', $path);
		
		echo '<pre>';
		var_export($array);
		echo '</pre>';
		
		if (strstr(array_pop($array), '.html')) {
			echo 'static';
			return;
		}
		
		if (preg_match('+d+', array_pop($array))) {
			echo 'content';
			return;
		}
		
		if (is_string(array_pop($array))) {
			echo 'category';
			return;
		}
		
	}
}