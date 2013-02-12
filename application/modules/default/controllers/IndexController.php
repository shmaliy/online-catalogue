<?php

class IndexController extends Sunny_Controller_Action
{
    public function init()
    {
        
	}

    public function indexAction()
    {
    	
    }
    
    public function presentationAction()
    {
    	$mapper = new Content_Model_Mapper_Cmscontent();
    	
    	$item = $mapper->fetchRow(
    		array(
    			"title_alias = ?" => 'presentation',
    			"parent_id = 0",
    			"published = 1"		
    		)		
    	);
    	
    	$this->view->item = $item;
    }
    
}



