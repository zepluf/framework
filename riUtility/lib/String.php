<?php
namespace plugins\riUtility;

class String{
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
}