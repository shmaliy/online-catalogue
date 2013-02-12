<?php

require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_Main extends Core_View_Helper_Abstract
{
    public function main()
    {
		$mainMapper = new Structure_Model_Mapper_Structure();
        $this->view->main = $mainMapper->getMain ($this->_lang);
        
        return $this->view->render('main.php3');
    }
}

