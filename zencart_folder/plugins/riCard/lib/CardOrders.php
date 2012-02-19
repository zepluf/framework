<?php 

namespace plugins\riCard;

use plugins\riPlugin\Object;
use plugins\riResultList\ResultSource;

class CardOrders extends ResultSource{	
	
	public function __call($name, $args){
		if(strpos($name, 'find') === 0){
			$name = substr($name, 3);
			$name{0} = Utility::fromCamelCase($name{0});
			
			switch($name){
				case 'all':
					//$args
					break;
			}
		}
	}
	
	public function getTotalNumberOfResults(){
		global $db;
		$sql = "SELECT COUNT(*) AS count FROM ".TABLE_CARD_ORDERS;
		
		$sql = $this->resultList_->buildBaseQuery($sql);
			
		$result = $db->execute($sql);
		return $result->fields['count'];
	}
	
	public function getResults($reload = false){
		global $db;
		
		$sql = "SELECT card_orders_id FROM ".TABLE_CARD_ORDERS;
		//generateQueryWhere()
		//generateQuery	

		$sql = $this->resultList_->buildPaginationQuery($sql);	
		
		$result = $db->execute($sql);
		
		$orders = array();
		while(!$result->EOF){
			$orders[] = $this->findById($result->fields['card_orders_id']);			
			$result->MoveNext();
		}
		return $orders;
	}
	
	public function getStatuses($languages_id = 1){
		global $db;
		$sql = "SELECT orders_status_id, orders_status_name FROM ".TABLE_ORDERS_STATUS. " WHERE language_id = :language_id";
		$sql = $db->bindVars($sql, ':language_id', $languages_id, 'integer');
		$result = $db->Execute($sql);
		
		$statuses = array(0 => 'Default');
		while(!$result->EOF){
			$statuses[$result->fields['orders_status_id']] = $result->fields['orders_status_name'];
			$result->MoveNext();			
		}
		
		return $statuses;
	}
	
	public function findById($orders_id, $customers_id = 0){
		global $db;
				
		// pull order info
		$sql = "SELECT * FROM ".TABLE_CARD_ORDERS." WHERE card_orders_id = :orders_id";
		$sql = $db->bindVars($sql, ':orders_id', $orders_id, 'integer');
		
		if($customers_id != 0){
			$sql .= " AND customers_id = :customers_id";
			$sql = $db->bindVars($sql, ':customers_id', $_SESSION['customer_id'], 'integer');
		}		
		
		$result = $db->Execute($sql);							
		
		// pull order cards
		if($result->RecordCount() > 0){
			$order = $this->container->get('riCard.CardOrder');
			$order->id = $orders_id;
			
			$order->info = $result->fields;
			$sql = "SELECT * FROM ".TABLE_CARD_ORDERS_CARDS." WHERE card_orders_id = :orders_id";
			$sql = $db->bindVars($sql, ':orders_id', $orders_id, 'integer');
			$result = $db->Execute($sql);
			while (!$result->EOF){
				$merchant = $this->container->get('riMerchant.Merchants')->findById($result->fields['merchants_id']);
				
				$card = $this->container->get('riCard.Card')->setArray(array(				    
					'merchant' => $merchant,					
					'faceValue' => $result->fields['face_value'],
					'buybackPercentage' => $result->fields['buyback_percentage'],
					'cashValue' => $result->fields['cash_value'],
					'amazonValue' => $result->fields['amazon_value'],
					'amazonFee' => $result->fields['amazon_fee'],
					'paypalValue' => $result->fields['paypal_value'],
					'pin'	=> $result->fields['pin'],
					'number' => $result->fields['number']				
				));
				$card->cardOrdersId = $orders_id;			
				$card->id = $card->uid = $result->fields['id'];			
				$order->getCards()->add($card);				
				$result->MoveNext();
			}					
			return $order;
		}

		return false;
	}		
	
	public function deleteById($orders_id){
		global $db;
		
		$sql = "DELETE FROM ".TABLE_CARD_ORDERS." WHERE card_orders_id = :orders_id";
		$sql = $db->bindVars($sql, ':orders_id', $orders_id, 'integer');
		$db->Execute($sql);
		
		$sql = "DELETE FROM ".TABLE_CARD_ORDERS_CARDS." WHERE card_orders_id = :orders_id";
		$sql = $db->bindVars($sql, ':orders_id', $orders_id, 'integer');
		$db->Execute($sql);				
	}
}