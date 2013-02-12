<?php

require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_AdminMenu extends Core_View_Helper_Abstract
{
    public function adminMenu()
    {
        $groupsMapper = new Contents_Model_Mapper_ContentsGroups();
        
        $groups = $groupsMapper->fetchTree(
        	array('admin_menu = ?' => 'YES')
        );
        
        //echo '<pre>';
        //var_export($groups);
        //echo '</pre>';
        
        $this->view->structure = $groups;
    	
    	//$this->view->one_colum = $contentsMapper->getFrontContentByAlias("pervaja-kolonka", $this->_lang);
    	//$this->view->two_colum = $contentsMapper->getFrontContentByAlias("druga-kolonka", $this->_lang);
    	
    	return $this->view->render('admin-menu.php3');
    }
}