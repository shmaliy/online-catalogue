<?php

require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_Path extends Core_View_Helper_Abstract
{
    public function path()
    {
        $path = '/uploads/';
        return $path;
    }
}

