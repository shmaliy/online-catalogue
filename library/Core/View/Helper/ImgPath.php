<?php

require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_ImgPath extends Core_View_Helper_Abstract
{
	public function ImgPath()
	{
		return $this;
	}
	
	public function getPathTree($categoryId, $catsArray = null)
	{
		$categoriesMapper = new Media_Model_Mapper_MediaCategories();
	
		$category = $categoriesMapper->findEntity($categoryId);
	
		$catsArray[] = $category;
		if ($category->mediaCategoriesId != 0) {
			$catsArray= $this->getPathTree($category->mediaCategoriesId, $catsArray);
		}
	
		return $catsArray;
	}
	
	public function makeUploadsDir($categoryId)
	{
		$tree = array();
		$subdirs = array();
		if ($categoryId > 0 ) {
			$tree = $this->getPathTree($categoryId);
				
			if (!empty($tree)) {
				foreach ($tree as $branch) {
					$subdirs[] = $branch->alias;
				}
				$subdirs = array_reverse($subdirs);
			}
		}
		
		$uploadspath = 'uploads';
			
		array_unshift($subdirs, $uploadspath);
			
		$fullpath = array(
			$_SERVER['DOCUMENT_ROOT'],
			implode('/', $subdirs)
		);
		
		$dir = implode('/',$fullpath);
		
		if ((!is_dir($dir) && mkdir($dir)) || is_dir($dir)) {
			return $dir;
		} else {
			return false;
		}
		
	}
	
	public function getWebPath($id)
	{
		$image = $this->getFullFileInfo($id);
		$image = explode('/', $image['shortpath']);
		unset($image[count($image)-1]);
		return implode('/', $image);
	}
	
	public function makeRealPath($tree) {
		
		if (!empty($tree)) {
			$tree = array_reverse($tree);
			$dirs = array();
			foreach ($tree as $branch) {
				$dirs[] = $branch->alias;
			}
			
			$dir = implode('/', $dirs);
		} else {
			$dir = '';
		}
	
		
	
		$fullpath =  $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $dir;
	
		if(!is_dir($fullpath)) {
			mkdir($fullpath, 0777);
		}
	
		$pathinfo = array(
				'fullpath'  => $fullpath,
				'shortpath' => '/uploads/'
		);
	
		return $pathinfo;
	}    
	
	public function getFullFileInfo($media_id)
	{
		$categoriesMapper = new Media_Model_Mapper_MediaCategories();
		$mediaMapper = new Media_Model_Mapper_Media();
		
		$file = $mediaMapper->findEntity($media_id);
		
		$tree = array();
		$subdirs = array();
		if ($file->mediaCategoriesId > 0 ) {
			$tree = $this->getPathTree($file->mediaCategoriesId);
			
			if (!empty($tree)) {
				foreach ($tree as $branch) {
					$subdirs[] = $branch->alias;
				}
			}
			
			$subdirs = array_reverse($subdirs);
		}
		
		$filename = $file->id . '.' . $file->type;
		$uploadspath = 'uploads';
		
		array_unshift($subdirs, $uploadspath);
		
		$fullpath = array(
			$_SERVER['DOCUMENT_ROOT'],
			implode('/', $subdirs),
			$filename
		);
		
		$shortpath = array(
			implode('/', $subdirs),
			$filename
		);
		
		if($file) {
			//$dir = $this->makeRealPath($this->getPathTree($file->mediaCategoriesId));
			
			$dir['fullpath'] = implode('/', $fullpath);
			$dir['shortpath'] = implode('/', $shortpath);
			
			return $dir;
		}
	} 
}

