<?php
namespace plugins\riUtility;

class Collection{
    public function removeValue(&$array, $value){
        $array = array_values(array_diff($array, array($value)));
    }

    public function insertValue(&$array, $value){                
        if(!in_array($value, $array)) $array[] = $value;
    }

    public function multiArrayDiff($array1,$array2){
        return array_filter($this->_multiArrayDiff($array1,$array2), 'strlen');
    }
    
    private function _multiArrayDiff($array1,$array2)
    {
        $ret = array(); 
        foreach ($array1 as $k => $v) { 
        if (!isset($array2[$k])) $ret[$k] = $v; 
        else if (is_array($v) && is_array($array2[$k])) $ret[$k] = $this->_multiArrayDiff($v, $array2[$k]); 
        else if ((string)$v != (string)$array2[$k]) $ret[$k] = $v; 
        } 
        return $ret; 
    }
}