<?php

namespace plugins\riStockNotification;

class StockNotification extends \plugins\riPlugin\Object{

	public function getNotifications($customers_id){
		$sql = "SELECT * FROM " . TABLE_STOCK_NOTIFICATIONS . " sn
				LEFT JOIN " . TABLE_CUSTOMERS . " c ON c.customers_id = sn.customers_id
				WHERE sn.customers_id = :customers_id";
		// zencart
		global $db;
		$sql = $db->bindVars($sql, ':customers_id', $customers_id, 'integer');
		$result = $db->Execute($sql);
		$notifications = array();
		while(!$result->EOF){
			$notifications[] = $result->fields;
			$result->MoveNext();	
		}
		
		return $notifications;
	}
	
    public function addNotification($notifications_type, $customers_id, $objects_id, $conditions_type, $conditions_value){
    	$sql = "INSERT IGNORE INTO " . TABLE_STOCK_NOTIFICATIONS . " (customers_id, objects_id, notifications_type, conditions_type, conditions_value) VALUES (:customers_id, :categories_id, :notifications_type, :conditions_type, :conditions_value)";

		// zencart
		global $db;
		$sql = $db->bindVars($sql, ':customers_id', $customers_id, 'integer');
		$sql = $db->bindVars($sql, ':categories_id', $objects_id, 'integer');
		$sql = $db->bindVars($sql, ':notifications_type', $notifications_type, 'integer');
		$sql = $db->bindVars($sql, ':conditions_type', $conditions_type, 'integer');
		$sql = $db->bindVars($sql, ':conditions_value', $conditions_value, 'string');
		$db->Execute($sql);
		
		return $db->insert_ID();
    }
	
    public function removeNotification($notifications_id, $customers_id){
    	global $db;
    	$sql = "DELETE FROM " . TABLE_STOCK_NOTIFICATIONS . " WHERE id = :notifications_id AND customers_id = :customers_id";
    	$sql = $db->bindVars($sql, ':customers_id', $customers_id, 'integer');
    	$sql = $db->bindVars($sql, ':notifications_id', $notifications_id, 'integer');
    	$db->Execute($sql);
    	return mysql_affected_rows() > 0;
    }
    
	public function prepareNotifications(){
		
		$sql = "SELECT * FROM " . TABLE_STOCK_NOTIFICATIONS . " sn
				LEFT JOIN " . TABLE_CUSTOMERS . " c ON c.customers_id = sn.customers_id";
		
		// zencart
		global $db;
		$notifications_list = array();
		$notifications = $db->Execute($sql);
		while(!$notifications->EOF){
			switch($notifications->fields['notifications_type']){
				case STOCK_NOTIFICATION_CATEGORY_TYPE:
					switch($notifications->fields['conditions_type']){
						case STOCK_NOTIFICATION_CONDITION_PRICE_RANGE:
							$range = explode(":", $notifications->fields['conditions_value']);
							
							$sql = "SELECT * FROM " . TABLE_PRODUCTS . " p 
							LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON pd.products_id = p.products_id	
							LEFT JOIN " . TABLE_CATEGORIES_DESCRIPTION . " cd ON cd.categories_id = p.master_categories_id								
							WHERE p.products_status = 1 AND p.products_quantity > 0";

							if($notifications->fields['objects_id'] > 0){
								$sql .= " AND p.master_categories_id = :categories_id";
								$sql = $db->bindVars($sql, ':categories_id', $notifications->fields['objects_id'], 'integer');
							}							
							
							if($range[0] != 0){
								$sql .= " AND p.products_price >= :products_price";
								$sql = $db->bindVars($sql, ':products_price', $range[0], 'float');	
							}
							
							if($range[1] != 0){
								$sql .= " AND p.products_price <= :products_price";
								$sql = $db->bindVars($sql, ':products_price', $range[1], 'float');	
							}																																	

							$result = $db->Execute($sql);
							if($result->RecordCount() == 0){
								$sql = "UPDATE " . TABLE_STOCK_NOTIFICATIONS . " SET status = 1 WHERE id = :id";
								$sql = $db->bindVars($sql, ':id', $notifications->fields['id'], 'integer');
								$db->Execute($sql);
							}
							else{
								if($notifications->fields['status'] == 1){
									$notifications_list[] = array('notification' => $notifications->fields, 'products' => $result->fields);
									$sql = "UPDATE " . TABLE_STOCK_NOTIFICATIONS . " SET status = 0 WHERE id = :id";
									$sql = $db->bindVars($sql, ':id', $notifications->fields['id'], 'integer');
									$db->Execute($sql);
								}
							}
							break;
					}					
					break;
					
			}		
			$notifications->MoveNext();	
		}

		return $notifications_list;
	}
	
	public function sendNotifications($notifications_list){
		foreach($notifications_list as $notification){
			$send_to_name = $notification['notification']['customers_firstname'] . ' ' . $notification['notification']['customers_lastname'];
			$send_to_email = $notification['notification']['customers_email_address'];
			$email_subject = "{merchant_name} is back in stock";
			$from_name = STORE_NAME;
			$from_email = EMAIL_FROM;
			// Prepare text-only portion of message
		    $text_message = "Please be advised that {merchant_name} is back in stock.\n\n" .
		    "You are receiving this email because you subscribed to our merchants back in stock feed. 
		    Please note: Popular merchants get sold out very quickly, we therefore suggest you act upon it quickly, to assure you can get your favorite merchant at discounted prices, before someone else does!\n\n".
			"To manage your subscriptions or to unsubscribe click the link below:\n".
		    "{link}";
		    
		    
		    $text_message = str_replace("{merchant_name}", $notification['products']['categories_name'], $text_message);
		    $text_message = str_replace("{link}", zen_href_link('stock_notifications'), $text_message);
		    $email_subject = str_replace("{merchant_name}", $notification['products']['categories_name'], $email_subject);
		    // Send message
			echo "$send_to_email - ";
		    zen_mail($send_to_name, $send_to_email, $email_subject, $text_message, $from_name, $from_email);		
		}		
	}
}