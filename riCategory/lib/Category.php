<?php 

namespace plugins\riCategory;

use plugins\riCore\Model;

class Category extends Model {
    protected $id = 'categories_id', $table = TABLE_CATEGORIES;
    
	private $description, $categories = array();
	
	// TODO: need to return false
	public function save(){
		global $db;
					
		$data = $this->getArray(array('description'));
		unset($data['id']);
		
		if(isset($this->categoriesId) && $this->categoriesId > 0){
			// TODO: description
			zen_db_perform(TABLE_CATEGORIES, $data, 'update', 'id = '.$this->id);
			return true;
		}
		else {
		    $data['date_added'] = 'now()';
			zen_db_perform(TABLE_CATEGORIES, $data);
			$this->categoriesId = $db->Insert_ID();
			
			// insert description
			$this->description->categoriesId = $this->categoriesId;
			$this->description->save(true);											
			
			return true;
		}

		return false;
	}
	
	public function getDescription($languages_id = 1){
	    
	    if(isset($this->description) && !empty($this->description)) return $this->description;
		global $db;
		$sql = "SELECT * FROM ".TABLE_CATEGORIES_DESCRIPTION." WHERE categories_id = :categories_id AND language_id = :languages_id";
		$sql = $db->bindVars($sql, ":categories_id", $this->categoriesId, 'integer');
		$sql = $db->bindVars($sql, ":languages_id", $languages_id, 'integer');
		
		$result = $db->Execute($sql);
		if($result->RecordCount() > 0){
		    $this->description = $this->container->get('riCategory.CategoriesDescription')->setArray($result->fields);		    
		}
		
		return $this->description;  
	} 
	
	public function setDescription($description){
	    $this->description = $description;
	}
}