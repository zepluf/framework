<?php
namespace plugins\riCustomer;

use plugins\riResultList\ResultSource;

use plugins\riPlugin\Object;

class Customers extends ResultSource{
	public function findById($customers_id){
		global $db;
		$sql = 'SELECT * FROM ' . TABLE_CUSTOMERS. ' WHERE customers_id = :customers_id';
		$sql = $db->bindVars($sql, ':customers_id', $customers_id, 'integer');
		$result = $db->Execute($sql);
		
		if($result->RecordCount() > 0){
			return $this->container->get('riCustomer.Customer')->setArray($result->fields);												
		}
		return false;	
	}
	
    public function findByEmailAddress($customers_email_address){
		global $db;
		$sql = 'SELECT * FROM ' . TABLE_CUSTOMERS. " WHERE customers_email_address LIKE ':customers_email_address%'";
		$sql = $db->bindVars($sql, ':customers_email_address', $customers_email_address, 'noquotestring');
		$result = $db->Execute($sql);
		
		if($result->RecordCount() > 0){
			return $this->container->get('riCustomer.Customer')->setArray($result->fields);												
		}
		return false;	
	}
	
	public function findByName($firstname = '', $lastname = ''){
	    global $db;
		if(!empty($firstname) || !empty($lastname)){
		    $sql = 'SELECT * FROM ' . TABLE_CUSTOMERS. ' WHERE ';
		    $where = array();
		    
		    if(!empty($firstname)){
		        $where[] = $db->bindVars(" customers_firstname LIKE ':customers_firstname%'", ':customers_firstname', $firstname, 'noquotestring');		        
		    }
		    if(!empty($lastname)){
		        $where[] = $db->bindVars(" customers_lastname LIKE ':customers_lastname%'", ':customers_lastname', $lastname, 'noquotestring');		        
		    }
		    
		    $sql .= implode(' AND ', $where);
		    
    		$result = $db->Execute($sql);
    		
    		if($result->RecordCount() > 0){
    			return $this->container->get('riCustomer.Customer')->setArray($result->fields);												
    		}
    		
    		return false;
		}
	    
		
		return false;	
	}	   
}