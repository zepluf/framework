<?php
namespace plugins\riPlugin;

class Settings{
	
	private $settings;
	
	public function set($key, $value, $merge = false){
	    if(!$merge)
		    $this->settings[$key] = $value;
		else{
		    if(!isset($this->settings[$key]) || !is_array($this->settings[$key]))
		        $this->settings[$key] = $value;
		    else 
		        $this->settings[$key] = array_merge_recursive($this->settings[$key], $value);
		}
	}
	
	public function get($key, $default = null){
		$key = explode('.', $key);
		return $this->_get($key, $this->settings);
	}
	
	private function _get($key, $settings){
		foreach($key as $k){
			if(isset($settings[$k])){
				array_shift($key);
				if(count($key) > 0)
					return $this->_get($key, $settings[$k]);
				else 
					return $settings[$k];
			}
			else 
				return false;
		}			
	}
}