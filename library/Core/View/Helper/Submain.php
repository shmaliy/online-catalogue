<?php

require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_Submain extends Core_View_Helper_Abstract {
	
	protected function _checkLevel($page) {

		$depth = 0;

		while ($page -> getParent() instanceof Zend_Navigation_Page) {
			$page = $page -> getParent();

			$depth++;
		}

		return $depth;

	}


	protected function _maxDepth($page, $depth = 0) {
		
		if (count($page) > 0) {
			foreach ($page as $item) {
				$idepth = $this -> _maxDepth($item, $depth);
				if ($depth < $idepth) {
					$depth = $idepth;
				}
			};

			$depth++;
		}

		return $depth;
	}
	
	
	
	public function submain($overrideUri = null) {

		if (null === $overrideUri) {
			$current = Zend_Registry::get('NAVIGATION') -> findOneBy('uri', rtrim($_SERVER['REQUEST_URI'], '/'));
			if (!$current) {
				$current = Zend_Registry::get('NAVIGATION') -> findOneBy('href', rtrim($_SERVER['REQUEST_URI'], '/'));
				if ($current) {
				$current -> setActive();
				}
			}
			if ($current) {
			$current -> setActive();
			}
			
		} else {
			
			$current = Zend_Registry::get('NAVIGATION') -> findOneBy('uri', $overrideUri);
		
			if (!$current) {
				$current = Zend_Registry::get('NAVIGATION') -> findOneBy('href', $overrideUri);
				if ($current) {
				$current -> setActive();
				}
			}
			if ($current) {
			$current -> setActive();
			}
			
		}

		if (!$current) {

			$currents = Zend_Registry::get('NAVIGATION') -> findAllBy('active', true);
			foreach ($currents as $current_item) {
				if ($current_item -> getHref() == rtrim($_SERVER['REQUEST_URI'], '/')) {
					$current = $current_item;
				};
			};
		}

		if (!$current) {

			return;
		}

		
   

		
		$page = $current;

		$delLevel = $this -> _checkLevel($page) - 2;
		if ($delLevel < 1) {$delLevel = 1;
		}

		while ($this -> _checkLevel($page) > $delLevel) {
			$page = $page -> getParent();
		}

		return $this -> view -> navigation() -> menu() -> setPartial(array('submain.php3', 'default')) -> render($page);

	}

}
