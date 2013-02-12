<?php

require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_Foutermain extends Core_View_Helper_Abstract
{
    public function foutermain()
    {
        $mainMapper = new Structure_Model_Mapper_Structure();
        $this->view->main = $mainMapper->getMain($this->_lang);
        
        return $this->view->render('foutermain.php3');
    }
}

