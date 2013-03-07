<?php
/**
 * Created by Rubikin Team.
 * Date: 3/4/13
 * Time: 5:41 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class SessionCart
{
    protected $productList = array();

    public function __construct()
    {

    }

    public function get($key)
    {
        if (isset($this->productList[$key])) {
            return $this->productList[$key];
        } else {
            return false;
        }
    }

    public function getAllProduct()
    {
        return $this->productList;
    }

    public function add($key, $value)
    {
        if (!isset($this->productList[$key])) {
            $this->productList[$key] = $value;
        } else {

        }
        # code...
    }

    public function remove($key)
    {
        unset($this->productList[$key]);
    }

    public function removeAll()
    {
        unset($this->productList);
        return $this;
    }
}
