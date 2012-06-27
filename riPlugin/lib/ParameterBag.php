<?php
/**
 * Created by RubikIntegration Team.
 * User: vunguyen
 * Date: 6/26/12
 * Time: 6:38 PM
 * Question? Come to our website at http://rubikintegration.com
 */

namespace plugins\riPlugin;

class ParameterBag{

    protected $_parameters, $_cache;

    public function set($key, $value, $merge = false){

        $key = explode('.', $key);

        $r = & $this->_parameters;
        foreach ($key as $k){
            if(!isset($r[$k])) $r[$k] = null;
            $r = & $r[$k];
        }

        if(!$merge || !is_array($r))
            $r = $value;
        else
            $r = array_merge_recursive($r, $value);

    }

    public function has($key){
        if(isset($this->_cache[$key])) return true;

        return $this->get($key, 'THISISADEFAULTKEY') != 'THISISADEFAULTKEY';
    }

    public function get($key = null, $default = null){
        if(empty($key)) return $this->_parameters;

        if(!isset($this->_cache[$key])){
            $_key = explode('.', $key);
            $this->_cache[$key] = $this->_get($_key, $this->_parameters, $default);
        }
        return $this->_cache[$key];
    }

    protected function _get($key, $settings, $default){
        foreach($key as $k){
            if(isset($settings[$k])){
                array_shift($key);
                if(count($key) > 0)
                    return $this->_get($key, $settings[$k], $default);
                else
                    return $settings[$k];
            }
            else
                return $default;
        }
    }
}