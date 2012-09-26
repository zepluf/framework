<?php 

namespace plugins\riCore;

use plugins\riUtility\String;

class Object implements \Serializable{
	protected $properties_ = array();		   

	/**
     * allows accessing $this->properties_[$key_name] by calling $object->keyName
     *
     * @param $key
     * @return null
     */
	public function __get($key){	
		return $this->get($key);        
	}

    /**
     * allows settings $this->properties_[$key_name] by calling $object->keyName = $value
     * @param $key
     * @return null
     */
	public function __set($key, $value){	
		return $this->set($key, $value);
	}

    /**
     * allows setting and getting $this->properties_ elements by calling $object->getKeyName() and $object->setKeyName($value)
     *
     * @param $name
     * @param $args
     * @return null
     */
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

    /**
     * checks if $this->properties_[$key] exists
     *
     * @param $key
     * @return bool
     */
	public function __isset($key){
		$key = String::fromCamelCase($key);
		return isset($this->properties_[$key]);
	}

    /**
     * checks if $this->properties_[$key] exists
     *
     * @param $key
     * @return bool
     */
	public function has($key){
	    return $this->__isset($key);
	}

    /**
     * sets element on $this->properties_
     *
     * @param $key
     * @param $value
     * @return Object
     */
	public function set($key, $value){
		$key = String::fromCamelCase($key);
		$this->properties_[$key] = $value;
		return $this;
	}

    /**
     * gets element on $this->properties_
     *
     * @param $key
     * @param null $default
     * @return null
     */
	public function get($key, $default = null){
		$key = String::fromCamelCase($key);
		return isset($this->properties_[$key]) ? $this->properties_[$key] : $default;		
	}

    /**
     * sets $this->properties_ using an array
     *
     * @param $array
     * @return Object
     */
	public function setArray($array){
		if(!is_array($array)) $array = array($array);
		
		foreach($array as $key => $value){
			$this->set($key, $value);	
		}
		return $this;
	}

    /**
     * gets $this->properties_ excluding certain keys
     *
     * @param array $exclude
     * @return array
     */
	public function getArray($exclude = array()){
	    $data = $this->properties_;
	    if(!empty($exclude))
	        foreach ($exclude as $key)
	            unset($data[$key]);
	            
		return $data;
	}
	
	/**
     * Serialize this instance.
     *
     * @return string
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