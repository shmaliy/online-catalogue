<?php

require_once "Zend/View/Helper/Abstract.php";

class Core_View_Helper_Abstract extends Zend_View_Helper_Abstract
{
	protected $_resizer;
    
    public function __construct()
    {
    	$this->_resizer = new Sunny_ImageResizer();
        
        require_once 'Zend/Controller/Action/HelperBroker.php';
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        if (null === $viewRenderer->view) {
            $viewRenderer->initView();
        }
        
        $viewRenderer->view->addScriptPath(APPLICATION_PATH . '/layouts/scripts');
        $this->setView($viewRenderer->view);
    }
    
    protected  function resize($image,$w,$h)
    {
        if (file_exists(ltrim($image, '/'))) {
            $savepath = explode('/', ltrim($image, '/'));
            $filename = $savepath[count($savepath)-1];
            $savepath[count($savepath)-1] = 'cache_'.$w.'x'.$h;
            $savepath[] = $filename;

            $cached = implode('/', $savepath);
    
             
            if (!file_exists($cached) || filemtime($cached) + 100000 < time()) {
                if (file_exists($cached)) {
                    unlink($cached);
                }
    
                $imageID = $this->_resizer->readImage(ltrim($image, '/'));
                if ($imageID) {
                    $imageID = $this->_resizer->resize(
                    $imageID,
                    $w,
                    $h,
                    Sunny_ImageResizer::FIT_BOX,
        						'center',
        						'center'
                    );
                }
    
                if ($imageID) {
                    $this->_resizer->writeImage($imageID, 'jpg', $cached, 90);
                }
            }
             
            $url = '/' . implode('/', $savepath);
        } else {
            $url = 'error';
        }
    
        return $url;
    }
}

