<?php 

namespace plugins\riProduct;

use plugins\riCore\Model;

class Product extends Model {
    protected $id = 'products_id', $table = TABLE_PRODUCTS;
    
	private $description, $categories = array();
	
	// TODO: need to return false
	public function save(){
		global $db;
					
		$data = $this->getArray(array('description'));
		unset($data['id']);
		
		if(isset($this->productsId) && $this->productsId > 0){
			// TODO: description
			zen_db_perform(TABLE_PRODUCTS, $data, 'update', 'id = '.$this->id);
			return true;
		}
		else {
		    $data['products_date_added'] = 'now()';
			zen_db_perform(TABLE_PRODUCTS, $data);
			$this->productsId = $db->Insert_ID();
			
			// insert description
			$this->description->productsId = $this->productsId;
			$this->description->save(true);						
			
			// insert 2 category relationship
			zen_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, array('products_id' => $this->productsId, 'categories_id' => $this->masterCategoriesId));
			
			return true;
		}

		return false;
	}
	
	public function getDescription($languages_id = 1){
	    
	    if(isset($this->description) && !empty($this->description)) return $this->description;
		global $db;
		$sql = "SELECT * FROM ".TABLE_PRODUCTS_DESCRIPTION." WHERE products_id = :products_id AND language_id = :languages_id";
		$sql = $db->bindVars($sql, ":products_id", $this->productsId, 'integer');
		$sql = $db->bindVars($sql, ":languages_id", $languages_id, 'integer');
		
		$result = $db->Execute($sql);
		if($result->RecordCount() > 0){
		    $this->description = $this->container->get('riProduct.ProductsDescription')->setArray($result->fields);		    
		}
		
		return $this->description;  
	} 
	
	public function setDescription($description){
	    $this->description = $description;
	}
}