<?php

require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_Content extends Core_View_Helper_Abstract
{
	public function content()
	{
		return $this;
	}

	public function test()
	{
		echo 1212121212;
	}
}
