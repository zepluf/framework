<?php
namespace plugins\riUtility;

class DatabaseResult{
    public static function dbToArrayWithKey($db_result){
		$result = array();
		if(is_object($db_result) && (get_class($db_result)  == 'queryFactoryResult')){			
			if($db_result->RecordCount() >0){
				while(!$db_result->EOF){	
					$result[] = $db_result->fields;
					$db_result->MoveNext();
				}	
				// move back to 0			
				$db_result->Move(0);
			}			
		}
		else 
			return false;
		
		return $result;		
	}
	
	public static function dbToArrayWithoutKey($db_result){
		$result = array();
		if(is_object($db_result) && (get_class($db_result)  == 'queryFactoryResult')){	
			$db_result = clone $db_result;		
			if($db_result->RecordCount() > 0){
				while(!$db_result->EOF){	
					$result[] = array_values($db_result->fields);
					$db_result->MoveNext();
				}	
				// move back to 0			
				// $db_result->Move(1);
			}			
		}
		else 
			return false;
		
		return $result;		
	}
}