<?php

require_once "Core/View/Helper/Abstract.php";

class Core_View_Helper_Shedule extends Core_View_Helper_Abstract
{
	public function Shedule()
	{
		return $this;
	}
	
	public function getGroupTitle($id) 
	{
		$mapper = new Shedule_Model_Mapper_SheduleGroups();
		$entity = $mapper->findEntity($id);
		return $entity->title;
	}
	
	public function getSubjectTitle($id) 
	{
		$mapper = new Onec_Model_Mapper_OnecDisciplins();
		$entity = $mapper->findEntity($id);
		return $entity->title;
	}
	
	public function getEmployer($id) 
	{
		$mapper = new Onec_Model_Mapper_OnecEmployees();
		$entity = $mapper->findEntity($id);
		return $entity->sname . ' ' . $entity->name;
	}
	
	public function getChair($id)
	{
		$mapper = new Onec_Model_Mapper_OnecChairs();
		$entity = $mapper->findEntity($id);
		return $entity->title;
	}
	
	public function getFaculty($id)
	{
		$mapper = new Onec_Model_Mapper_OnecFacultys();
		$entity = $mapper->findEntity($id);
		return $entity->title;
	}
}