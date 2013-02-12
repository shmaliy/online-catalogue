<?php

require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_Fouter extends Core_View_Helper_Abstract
{
    public function fouter()
    {
        $contentsMapper = new Contents_Model_Mapper_Contents();
    	
    	$this->view->one_colum = $contentsMapper->getFrontContentByAlias("pervaja-kolonka", $this->_lang);
    	$this->view->two_colum = $contentsMapper->getFrontContentByAlias("druga-kolonka", $this->_lang);
    	
    	return $this->view->render('fouter.php3');
    }
}

