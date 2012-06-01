<?php
namespace plugins\riUtility;

class Collection{
    public function removeValue(&$array, $value){
        $array = array_values(array_diff($array, array($value)));
    }
    
    public function insertValue(&$array, $value){
        if(!in_array($value, $array)) $array[] = $value;
    }
}