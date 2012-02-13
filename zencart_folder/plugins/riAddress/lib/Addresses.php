<?php

namespace plugins\riAddress;

use plugins\riResultList\ResultSource;

class Addresses extends ResultSource{
    public function findById($address_book_id){
		global $db;
		$sql = 'SELECT * FROM ' . TABLE_ADDRESS_BOOK . '
		WHERE address_book_id = :address_book_id';
		
		$sql = $db->bindVars($sql, ':address_book_id', $address_book_id, 'integer');
		
		$result = $db->Execute($sql);
		if($result->RecordCount() > 0){
			$address = $this->container->get('riAddress.Address')->setArray($result->fields);							
			return $address;		
		}
		return false;				
	}
}