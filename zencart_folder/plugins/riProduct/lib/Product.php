<?php 

namespace plugins\riProduct;

use plugins\riPlugin\Object;

class Product extends Object {
	private $description, $categories = array();
	
	// TODO: need to return false
	public function save(){
		global $db;
					
		$data = $this->getArray();
		unset($data['id']);
		
		if(isset($this->id) && $this->id > 0){
			// TODO: description
			zen_db_perform(TABLE_PRODUCTS, $data, 'update', 'id = '.$this->id);
			return true;
		}
		else {
			zen_db_perform(TABLE_PRODUCTS, $data);
			$this->id = $db->Insert_ID();
			
			$this->description['products_id'] = $this->id;
			zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $this->description);
			zen_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, array('products_id' => $this->id, 'categories_id' => $this->masterCategoriesId));
			
			return true;
		}

		return false;
	}
	
	public function getDescription($languages_id = 1){
		global $db;
		$sql = "SELECT * FROM ".TABLE_PRODUCTS_DESCRIPTION." WHERE products_id = :products_id AND language_id = :languages_id";
		$sql = $db->bindVars($sql, ":products_id", $this->id, 'integer');
		$sql = $db->bindVars($sql, ":languages_id", $languages_id, 'integer');
		$result = $db->Execute($sql);
		if($result->RecordCount() > 0)
		$this->description = $result->fields;
	} 
}