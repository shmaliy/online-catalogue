<?php

require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_Swichpage extends Core_View_Helper_Abstract
{
    public function swichpage()
    {

        return $this->view->render('swichpage.php3');
    }

    
    
}

