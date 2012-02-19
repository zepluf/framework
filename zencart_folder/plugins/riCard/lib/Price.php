<?php
namespace plugins\riCard;

use plugins\riPlugin\Object;

class Price extends Object{		
	
	public function getDiscount($merchants_id, $buyback_percentage){
		if(!isset($this->customersId) || $this->customersId == 0)
			return $buyback_percentage;
		
		global $db;
		$sql = "SELECT discount_percentage FROM ".TABLE_CARD_DISCOUNTS." WHERE customers_id = :customers_id";
		$sql = $db->bindVars($sql, ":customers_id", $this->customersId, "integer");
		
		$individual_sql = $sql . " AND merchants_id = :merchants_id";		
		$individual_sql = $db->bindVars($individual_sql, ":merchants_id", $merchants_id, "integer");
		
		$result = $db->Execute($individual_sql);
		if($result->RecordCount() > 0)
			return $result->fields['discount_percentage'];
		else{
			$general_sql = $sql . " AND merchants_id = 0";
			$result = $db->Execute($general_sql);
			if($result->RecordCount() > 0)
				return $buyback_percentage+$result->fields['discount_percentage'];
		}		
		return $buyback_percentage;
	}
}