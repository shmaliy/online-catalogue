<?php

class IndexController extends Zend_Controller_Action
{
	public function init()
    {
    	$context = $this->_helper->AjaxContext();
        $context->addActionContext('index', 'json');
        $context->addActionContext('ajax-language', 'json');
        $context->initContext('json');
    }

    public function indexAction()
    {
        
    }
    
}



