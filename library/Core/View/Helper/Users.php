<?php

require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_Users extends Core_View_Helper_Abstract
{
	public function users()
    {
    	$this->view->user = Zend_Auth::getInstance()->getStorage()->read();
    	//var_export($this->view->user);
    	
		return $this->view->render('users.php3');
    }
}

