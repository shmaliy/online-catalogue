<?php

require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_Lang extends Core_View_Helper_Abstract
{
	public function lang()
    {
		$langsMapper = new Contents_Model_Mapper_Languages();
		$this->view->langs = $langsMapper->getAllLang();
        return $this->view->render('lang.php3');
    }
}

