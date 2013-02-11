<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Max
 * Date: 05.10.12
 * Time: 12:09
 * To change this template use File | Settings | File Templates.
 */
class Core_View_Helper_Navigation_Breadcrumbs
        extends Zend_View_Helper_Navigation_Breadcrumbs
{
    public function breadcrumbs(Zend_Navigation_Container $container = null)
    {
        if (null !== $container) {
            $this->setContainer($container);
        }

        //return $this;
    }
}