<?php

require_once "Core/View/Helper/Abstract.php";
require_once "Core/View/Helper/ImgPath.php";

class Core_View_Helper_Structure extends Core_View_Helper_Abstract
{
	public function structure()
	{
		return $this;
	}

	public function chiefRight($id, $title, $contacts = true)
	{
		if (is_null($id)) {
			return;
		}
		
		$mapper = new Onec_Model_Mapper_OnecEmployees();
		
		//echo $id;
		
		$this->view->chief = $mapper->getChiefInfo($id);
		$this->view->title = $title;
		$this->view->contacts = $contacts;
		
		if (!empty($this->view->chief) && $this->view->chief != false) {
			
			$path = new Core_View_Helper_ImgPath();
			
			$this->view->photo = false;
			if ($this->view->chief['media_id'] > 0) {
				$photo = $path->getFullFileInfo($this->view->chief['media_id']);
				$this->view->photo = $photo['shortpath'];
			}
			
			return $this->view->render('chief-right.php3');
		}
		
		return;
	}
	
	public function adminFacultyChief($id)
	{
		if (is_null($id)) {
			return;
		}
	
		$mapper = new Onec_Model_Mapper_OnecEmployees();
	
		//echo $id;
	
		$chief = $mapper->getChiefInfo($id);
		
		if (!empty($chief) && $this != false) {
				
			return $chief['sname'] . ' ' . $chief['name'];
		}
	
		return;
	}
	
	public function adminChairChief($id) {
		$chairsMapper = new Onec_Model_Mapper_OnecChairs();
		
		$chair = $chairsMapper->getChair($id);
		
		$return = array();
		
		if ($chair) {
			$return = array(
				"id"   => $chair['chief_id'],
				"name" => $chair['e_sname'] . ' ' . $chair['e_name']	 	
			);
		}
		
		return $return;
	}
	
	public function chairChiefRight($id, $title, $contacts = true)
	{
		if (is_null($id)) {
			return;
		}
		
		$chMapper = new Onec_Model_Mapper_OnecChairs();
		$mapper = new Onec_Model_Mapper_OnecEmployees();
		
		$chair = $chMapper->getChair($id);
		
		$path = new Core_View_Helper_ImgPath();
		
		$this->view->photo = false;
		if ($chair['e_media_id'] > 0) {
			$photo = $path->getFullFileInfo($chair['e_media_id']);
			$this->view->photo = $photo['shortpath'];
		}
		
		$this->view->title = $title;
		$this->view->contacts = $contacts;
		$this->view->chief = $mapper->getChiefInfo($chair['chief_id']);
		
		return $this->view->render('chief-right.php3');
	}
	
	public function globalContactsRight($entity, $title)
	{
		if(!empty($entity->contacts) || !empty($entity->contacts_ru) || !empty($entity->contacts_en)) {
			$this->view->entity = $entity;
			$this->view->title = $title;
			return $this->view->render('global-contacts-right.php3');
		}
		
		return false;
	}
	
	public function chairsListRight($facultyId, $title)
	{
		$mapper = new Onec_Model_Mapper_OnecChairs();
		if($facultyId > 0) {
			$list = $mapper->getChairsInFaculty($facultyId);
			
			//var_export($list);
			
			if(is_array($list) && !empty($list)) {
				$this->view->chairs = $list;
				$this->view->title = $title;
				
				/*echo '<pre>';
				 var_export($this->view->chairs);
				echo '</pre>';*/
				
				return $this->view->render('chairs-list-right.php3');
			}
			
			return;
			$collection = $mapper->fetchAll(
				array(
					'onec_facultys_id = ?' => $facultyId,
					'ignored = ?' => 0
				)
			);
		
		
			if (count($collection) > 0) {
				$this->view->chairs = $collection;
				$this->view->title = $title;
				
				/*echo '<pre>';
				var_export($this->view->chairs);
				echo '</pre>';*/
				
				return $this->view->render('chairs-list-right.php3');
			}
			return false;
		} else {
			return false;
		}
	}
	
	public function disciplinesListRight($facultyId, $title)
	{
		$chairsMapper = new Onec_Model_Mapper_OnecChairs();
		$mapper = new Onec_Model_Mapper_OnecDisciplins();
		$facultysMapper = new Onec_Model_Mapper_OnecFacultys();
		
		if($facultyId > 0) {
			
			$list = $facultysMapper->facultyDisciplinesList($facultyId);
			//var_export($list);
			
			if (!empty($list)) {
				$this->view->title = $title;
				$this->view->disciplins = $list;
				return $this->view->render('disciplines-list-right.php3');
			}
			return;
			
		} else {
			return false;
		}
	}
	
	public function disciplinesChairListRight($id, $title, $onecFacultysId)
	{
		$mapper = new Onec_Model_Mapper_OnecDisciplins();
		$this->view->disciplins = $mapper->fetchAll(
			array(
				'onec_chairs_id = ?' => $id,
				'ignored = ?'        => 0
				)
		);
		
		if (count($this->view->disciplins) > 0) {
			$this->view->title = $title;
			$this->view->faculty = $onecFacultysId;
			return $this->view->render('disciplines-chair-list-right.php3');
		}
		return false;
	}
	
	public function departmentStaffList($departmentId, $title)
	{
		$mapper = new Onec_Model_Mapper_OnecEmployees();
		
		$list = $mapper->getDepartmentsStuff($departmentId);
		
		$this->view->list = $mapper->getDepartmentsStuff($departmentId);
		if (count($this->view->list) > 0) {
			$this->view->title = $title;
			return $this->view->render('department-staff-list.php3');
		} else {
			return;
		}
		
		
		
		$this->view->collection = $mapper->fetchAll(
			array('onec_departments_id = ?' => $departmentId)
		);
		
		if (count($this->view->collection) > 0) {
			$this->view->title = $title;
			return $this->view->render('department-staff-list.php3');
		} else {
			return;
		}
		
// 		echo '<pre>';
// 		var_export($this->view->collection);
// 		echo '</pre>';
	}
	
	public function chairStaffList($chairId, $title)
	{
		$mapper = new Onec_Model_Mapper_OnecEmployees();
	
		$this->view->collection = $mapper->fetchAll(
		array('onec_chairs_id = ?' => $chairId)
		);
	
		if (count($this->view->collection) > 0) {
			$this->view->title = $title;
			return $this->view->render('chair-staff-list.php3');
		} else {
			return;
		}
	
		echo '<pre>';
		var_export($this->view->collection);
		echo '</pre>';
	}
	
	public function getDegree($id, $lang = 'uk')
	{
		if ($lang == 'uk') {
			$colName = 'title';
		} else {
			$colName = 'title_' . $lang;
		}
		$mapper = new Onec_Model_Mapper_OnecDegrees();
		$entity = $mapper->findEntity($id, array($colName));
		return $entity->__get($colName);
	}
	
	public function employerPost($id, $lang = 'uk')
	{
		//return 123;
		if ($lang == 'uk') {
			$colName = 'title';
		} else {
			$colName = 'title_' . $lang;
		}
		$mapper = new Onec_Model_Mapper_OnecPosts();
		$entity = $mapper->findEntity($id);
		if($entity) {
			return $entity->__get($colName);
		}
		return false;
	}
	
	public function employerDegree($id, $lang = 'uk')
	{
		//return 123;
		if ($lang == 'uk') {
			$colName = 'title';
		} else {
			$colName = 'title_' . $lang;
		}
		$mapper = new Onec_Model_Mapper_OnecDegrees();
		$entity = $mapper->findEntity($id);
		if($entity) {
			return $entity->__get($colName);
		}
		return false;
	}
	
	public function mainEmployersList($chair, $facultyId) {
		//echo $chairId;
		
		if (empty($chair)) {
			return;
		}
		
		$depId = $chair['dep_id'];
		
		$pMapper = new Onec_Model_Mapper_OnecPosts();
		
		$list = $pMapper->getDepStaffList($depId);
		
// 		echo '<pre>';
// 		var_export($list);
// 		echo '</pre>';
		
		$this->view->chairId = $chair['onec_chairs_id'];
		$this->view->facultyId = $facultyId;
		$this->view->collection = $list;
		
		return $this->view->render('main-employer-list.php3');
		
	}
}
