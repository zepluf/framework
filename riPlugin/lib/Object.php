<?php 

namespace plugins\riPlugin;

use plugins\riUtility\String;

class Object implements \Serializable{
	protected $properties_ = array();		   
    
	/**
    /**
     * Destruct instance.
     */
    public function __destruct() {
    }
	
	public function __get($key){	
		return $this->get($key);        
	}

	public function __set($key, $value){	
		return $this->set($key, $value);
	}
	
	public function __call($name, $args){	
		if(strpos($name, 'get') === 0){
			$name = substr($name, 3);
			return $this->get($name);
		}
		elseif(strpos($name, 'set') === 0){
			$name = substr($name, 3);
			$this->set($name, $args[0]);
		}
	}
	
	public function __isset($key){
		$key = String::fromCamelCase($key);
		return isset($this->properties_[$key]);
	}
	
	public function has($key){
	    return $this->__isset($key);
	}
	
	public function set($key, $value){
		$key = String::fromCamelCase($key);
		$this->properties_[$key] = $value;
		return $this;
	}
	
	public function get($key, $default = null){
		$key = String::fromCamelCase($key);
		return isset($this->properties_[$key]) ? $this->properties_[$key] : $default;		
	}
	
	public function setArray($array){
		if(!is_array($array)) $array = array($array);
		
		foreach($array as $key => $value){
			$this->set($key, $value);	
		}
		return $this;
	}
	
	public function getArray($exclude = array()){
	    $data = $this->properties_;
	    if(!empty($exclude))
	        foreach ($exclude as $key)
	            unset($data[$key]);
	            
		return $data;
	}
	
	/**
     * Serialize this instance.
     */
    public function serialize() {
        $sprops = array();
        foreach ($this->getProperties() as $name => $obj) {
            $sprops[$name] = serialize($obj);
        }

        $serialized = serialize($sprops);

        if (function_exists('gzcompress')) {
            $serialized =  base64_encode(gzcompress($serialized));
        }

        return $serialized;
    }

    /**
     * Unserialize.
     *
     * @param string serialized The serialized data.
     */
    public function unserialize($serialized) {
        if (function_exists('gzcompress')) {
            $serialized = base64_decode(gzuncompress($serialized));
        }

        $sprops = base64_decode(unserialize($serialized));

        foreach ($sprops as $name => $sprop) {
            $this->set($name, unserialize($sprop));
        }
    }
}