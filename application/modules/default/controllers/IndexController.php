<?php

class IndexController extends Sunny_Controller_Action
{
    public function init()
    {
        
	}

    public function indexAction()
    {
    	$mapper = new Content_Model_Mapper_Cmscontent();
    	
    	echo '<pre>';
    	var_export($mapper->fetchAll());
    	echo '</pre>';
    	$request = $this->getRequest();
    	$params = $request->getParams();
    }
    
}



