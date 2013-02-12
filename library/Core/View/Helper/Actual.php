<?php

require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_Actual extends Core_View_Helper_Abstract
{
    public function actual()
    {
        $groupsMapper = new Contents_Model_Mapper_ContentsGroups();
        
        $this->view->agroup = $groupsMapper->getFrontGroupByAlias("announcements");
        $this->view->ngroup = $groupsMapper->getFrontGroupByAlias("news");
        $this->view->egroup = $groupsMapper->getFrontGroupByAlias("events");
        $this->view->group  = $groupsMapper->getFrontGroup();
        
        $catMapper = new Contents_Model_Mapper_ContentsCategories();
        
        $this->view->acats = $catMapper->getFrontCatsByGroupId($this->view->agroup->id, $this->_lang);
        $this->view->ncats = $catMapper->getFrontCatsByGroupId($this->view->ngroup->id, $this->_lang);
        $this->view->ecats = $catMapper->getFrontCatsByGroupId($this->view->egroup->id, $this->_lang);
        $this->view->cats  = $catMapper->getFrontCats();
        
        
        $contentsMapper = new Contents_Model_Mapper_Contents();
        
        $this->view->events        = $contentsMapper->getFrontContentsByGroupId($this->view->agroup->id, $this->_lang,'frontend_date  desc');
        $this->view->announcements = $contentsMapper->getFrontContentsByGroupId($this->view->agroup->id, $this->_lang,'frontend_date  desc');
        $this->view->news          = $contentsMapper->getFrontContentsByGroupId($this->view->ngroup->id, $this->_lang, 'frontend_date  desc');
        
        $this->view->actuals = $contentsMapper->getFrontContentsByGroupId(
        	array ($this->view->egroup->id, $this->view->agroup->id, $this->view->ngroup->id),
        	$this->_lang,
        	'frontend_date  desc',
        	5
		)->toArray();
        
        $imgMapper = new Media_Model_Mapper_Media();
        $this->view->imgs = $imgMapper->getContentImgAll();
        
        $resizer = array();
        foreach ($this->view->actuals as $item) {
        	if ($item['media_id'] > 0) {

                        $dir = $this->view->imgPath()->getFullFileInfo($item['media_id']);

        				$item['small'] = $this->resize($dir['shortpath'], 40, 40);

        	} else {

            	$item['small'] = '';
            	
        	}
        	
        	$resizer[] = $item;
        }

        $this->view->actual = $resizer;
        return $this->view->render('actual.php3');
    }

    
    
}

