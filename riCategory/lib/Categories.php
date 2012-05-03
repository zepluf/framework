<?php

namespace plugins\riCategory;

use plugins\riCore\Collection;

class Categories extends Collection{	
	
    protected $from = TABLE_CATEGORIES;
		
	public function findByName($categories_name, $limit = 20){
		global $db;
		$sql = "SELECT c.* 
		        FROM " . TABLE_CATEGORIES . " c," . TABLE_CATEGORIES_DESCRIPTION . " cd
		 	    WHERE c.categories_id = cd.categories_id
				AND cd.language_id = :languages_id
				AND categories_name like ':categories_name%'";
		
		if($limit > 0) $sql .= " limit $limit";
		
		$sql = $db->bindVars($sql, ":languages_id", $_SESSION['languages_id'], 'integer');
		$sql = $db->bindVars($sql, ":categories_name", $categories_name, 'noquotestring');
		$result = $db->Execute($sql);
		
		if($result->RecordCount() > 0){
			$collection = array();
			while(!$result->EOF){
				$category = $this->container->get('riCategory.Category');			
				$category->setArray($result->fields);	
				$collection[] = $category;
				$result->MoveNext();
			}		
			return $collection;
		}
		
		return false;
	}
	
	public function getResultClass(){
		
		
	}
	
	public function isFinal(){
		
	}
}