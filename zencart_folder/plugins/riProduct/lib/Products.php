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
	
	public function findByName($products_name, $limit = 20){
		global $db;
		$sql = "SELECT p.* 
		        FROM " . TABLE_PRODUCTS . " p," . TABLE_PRODUCTS_DESCRIPTION . " pd
		 	    WHERE pd.products_id = p.products_id
				AND pd.language_id = 1
				AND products_name like ':products_name%'";
		$sql = $db->bindVars($sql, ":products_name", $products_name, 'noquotestring');
		$result = $db->Execute($sql);
		
		if($result->RecordCount() > 0){
			$collection = array();
			while(!$result->EOF){
				$product = $this->container->get('riProduct.Product');			
				$product->setArray($result->fields);	
				$collection[] = $product;
				$result->MoveNext();
			}		
			return $collection;
		}
		
		return false;
	}
}