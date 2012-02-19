<?php 

namespace plugins\riCard;

use plugins\riResultList\ResultSource;

class CardDiscounts extends ResultSource{	
	    
	public function getTotalNumberOfResults(){
		global $db;
		$sql = "SELECT COUNT(*) AS count FROM " . TABLE_CARD_DISCOUNTS;
		
		$sql = $this->resultList_->buildBaseQuery($sql);
			
		$result = $db->execute($sql);
		return $result->fields['count'];
	}
	
	public function getResults($reload = false){
		global $db;
		
		$sql = "SELECT * FROM " . TABLE_CARD_DISCOUNTS;
		//generateQueryWhere()
		//generateQuery	

		$sql = $this->resultList_->buildPaginationQuery($sql);	
		
		$result = $db->execute($sql);
		
		$results = array();
		while(!$result->EOF){
			$results[] = $this->findById($result->fields['card_discounts_id']);			
			$result->MoveNext();
		}
		return $results;
	}

	public function findById($card_discounts_id){
	    global $db;
		
		$sql = "SELECT * FROM " . TABLE_CARD_DISCOUNTS . " WHERE card_discounts_id = :card_discounts_id";
		$sql = $db->bindVars($sql, ':card_discounts_id', $card_discounts_id, 'integer');
		
		$result = $db->Execute($sql);
		
		if($result->RecordCount() > 0)
		    return $this->container->get('riCard.CardDiscount')->setArray($result->fields);
		else 
		    return false;
	}
}