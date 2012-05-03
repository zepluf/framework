<?php
namespace plugins\riPlugin;

class Settings{

    private $settings, $cache;

    public function set($key, $value, $merge = false){
         
        $key = explode('.', $key);
         
        $r = & $this->settings;
        foreach ($key as $k){
            if(!isset($r[$k])) $r[$k] = null;
            $r = & $r[$k];            
        }
         
        if(!$merge || !is_array($r))
            $r = $value;
        else
            $r = array_merge_recursive($r, $value);
            
    }

    public function get($key, $default = null){
        if(!isset($this->cache[$key])){
            $_key = explode('.', $key);
            $this->cache[$key] = $this->_get($_key, $this->settings);
        }
        return $this->cache[$key];
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