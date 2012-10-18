<?php
/**
 * Created by RubikIntegration Team.
 * User: vunguyen
 * Date: 6/26/12
 * Time: 6:38 PM
 * Question? Come to our website at http://rubikin.com
 */

namespace plugins\riCore;

/**
 * parameterBag holding key/value pair
 */
class ParameterBag
{

    const DEFAULT_KEY = 'THISISADEFAULTKEY';

    /**
     * parameter array
     *
     * @var
     */
    protected $_parameters;

    /**
     * cache array
     *
     * @var
     */
    protected $_cache;

    /**
     * sets a new/existing key/value into the bag
     * it's possible to do set('multi.array.level', $value) which will be similar to
     * $this->$_parameters['nulti']['array']['level'] = $value
     *
     * @param $key
     * @param $value
     * @param bool $merge
     */
    public function set($key, $value, $merge = false)
    {

        $key = explode('.', $key);

        $r = & $this->_parameters;
        $keys = array();
        foreach ($key as $k) {
            if (!isset($r[$k])) $r[$k] = null;
            $r = & $r[$k];

            // we need to reset cache
            $keys[] = $k;
            unset($this->_cache[implode('.', $keys)]);
        }

        if (!$merge || !is_array($r))
            $r = $value;
        else {
            $r = arrayMergeWithReplace($r, $value);
        }
    }

    /**
     * Unsets a key
     *
     * @param $key
     */
    public function remove($key)
    {
        $_key = explode('.', $key);
        $_keyCount = count($_key);
        $r = & $this->_parameters;
        foreach ($_key as $k) {
            if (!isset($r[$k])) break;

            if ($_keyCount == 1) {
                if (isset($r[$k])) unset($r[$k]);
                break;
            }
            else {
                $r = & $r[$k];
            }

            $_keyCount--;
        }

        unset($this->_cache[$key]);
    }

    /**
     * checks if a key exists, it's possible to use multi.array.level here
     *
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        if (isset($this->_cache[$key])) return true;

        return $this->get($key, 'THISISADEFAULTKEY') != 'THISISADEFAULTKEY';
    }

    /**
     * gets the value of a key, it's possible to use multi.array.level here
     *
     * @param null $key
     * @param string $default is optional, is used to return if the key does not exist
     * @return mixed
     */
    public function get($key = null, $default = self::DEFAULT_KEY)
    {
        if (empty($key)) return $this->_parameters;

        if (!isset($this->_cache[$key])) {
            $_key = explode('.', $key);
            $this->_cache[$key] = $this->_get($_key, $this->_parameters, $default);
        }
        return $this->_cache[$key];
    }

    /**
     * helper for the get method
     *
     * @param $key
     * @param $settings
     * @param $default
     * @return mixed
     */
    protected function _get($key, $settings, $default)
    {
        foreach ($key as $k) {
            if (array_key_exists($k, $settings)) {
                array_shift($key);
                if (count($key) > 0) {
                    return $this->_get($key, $settings[$k], $default);
                }
                else {
                    return $settings[$k];
                }
            }
            else {
                return $default;
            }
        }
    }
}