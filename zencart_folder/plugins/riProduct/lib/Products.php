<?php
namespace plugins\riProduct;

use plugins\riPlugin\Object;

class Products extends Object{
	public function findById($products_id){
		global $db;
		$sql = "SELECT * FROM ".TABLE_PRODUCTS." WHERE products_id = :products_id";
		$sql = $db->bindVars($sql, ":products_id", $products_id, 'integer');
		$result = $db->Execute($sql);
		
		if($result->RecordCount() > 0){
			$product = $this->container->get('riProduct.Product');			
			$product->setArray($result->fields);
			return $product;
		}
		
		return false;
	}
}