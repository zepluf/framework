<?php
namespace plugins\riUtility;

class Utility{
	public static function fromCamelCase($str, $glue='_'){
		 return preg_replace(
	    '/(^|[a-z])([A-Z])/e', 
	    'strtolower(strlen("\\1") ? "\\1_\\2" : "\\2")',
	    $str 
  		); 
	}
	
	public static function toCamelCase($string, $capitaliseFirstChar = false){
		$string = str_replace(array('-', '_'), ' ', $string); 
		$string = ucwords($string); 
		$string = str_replace(' ', '', $string);  
		
		if (!$capitaliseFirstChar) { 
			return lcfirst($string); 
		} 
		return $string; 
	}
	
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