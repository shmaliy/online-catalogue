<?php

require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_Comments extends Core_View_Helper_Abstract
{
    public function comments($alias, $cat, $enable)
    {

        $this->view->cat = $cat;
        $this->view->enable = $enable;
        $commentsMapper = new Contents_Model_Mapper_Comments();
        $categoriesMapper = new Contents_Model_Mapper_ContentsCategories();
        $this->view->comment = $commentsMapper->getFrontCommentsByAlias($alias);

        $usersMapper = new Users_Model_Mapper_Users();
        $this->view->users = $usersMapper->getAllUser();


        $this->view->alias = $alias;
        $this->view->user = Zend_Auth::getInstance()->getStorage()->read();
        if ($cat != 0) {
            $this->view->cat = $categoriesMapper->getCatById($cat, $this->_lang);
            if ($this->view->cat->contents_categories_id != 0) {
                $this->view->cat_head = $categoriesMapper->getCatById($this->view->cat->contents_categories_id, $this->_lang);
            }
        } else {
            if ($enable == 1) {
                return $this->view->render('comments.php3');
            }
        }
        if ($this->view->cat_head->enable_comments == 1) {
            if ($this->view->cat->enable_comments == 1) {
                if ($enable == 1) {
                    return $this->view->render('comments.php3');
                }
            }
        }

    }
}

