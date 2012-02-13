<?php

namespace plugins\riAddress;

use plugins\riResultList\ResultSource;

class Countries extends ResultSource{
    public function findById($countries_id){
		global $db;
		$sql = 'SELECT * FROM ' . TABLE_COUNTRIES . '
		WHERE countries_id = :countries_id';
		
		$sql = $db->bindVars($sql, ':countries_id', $countries_id, 'integer');
		
		$result = $db->Execute($sql);
		if($result->RecordCount() > 0){
			$country = $this->container->get('riAddress.Country')->setArray($result->fields);							
			return $country;		
		}
		return false;				
	}
}