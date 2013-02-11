<?php

class Menu_IndexController extends Sunny_Controller_Action
{
	public function init()
    {
    	$context = $this->_helper->AjaxContext();
        $context->addActionContext('index', 'json');
        $context->initContext('json');
    }

    public function indexAction()
    {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	
    	$alias = $request->getParam('alias', null);
    	
    	$menuMapper = new Menu_Model_Mappers_CmsMenu();
    	
    	$where = null;
    	if (!is_null($alias)) {
    		$where = array('title_alias => ?' => $alias);
    	}
    	
    	$items = $menuMapper->fetchTree($where, array('parent_id'), 'ordering');
    	
    	echo '<pre>';
    	var_export($items);
    	echo '</pre>';
    }
    
}



