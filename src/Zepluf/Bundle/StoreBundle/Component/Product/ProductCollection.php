<?php
/**
 * Created by Rubikin Team.
 * Date: 3/4/13
 * Time: 5:41 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Product;

class ProductCollection
{
    protected $productCollection = array();

    public function get($key = null)
    {
        if (empty($key)) {
            return $this->productCollection;
        } elseif (isset($this->productCollection[$key])) {
            return $this->productCollection[$key];
        } else {
            return false;
        }
    }

    /**
     * adds a new product to collection
     *
     * @param $productId
     * @param $quantity
     * @param array $features
     */
    public function add($productId, $quantity, $features = array())
    {
        $key = $this->generateKey($productId, $features);

        if (!isset($this->productCollection[$key])) {
            $this->productCollection[$key] = array(
                'productId' => $productId,
                'quantity' => $quantity,
                'features' => $features
            );
        } else {
            $this->productCollection[$key]['quantity'] += $quantity;
        }
    }

    public function update($key, $quantity)
    {
        if(0 == $quantity) {
            return $this->remove($key);
        }
        else {
            $this->productCollection[$key]['quantity'] = $quantity;
        }

        return true;
    }

    /**
     * removes current product from collection
     *
     * @param $key
     */
    public function remove($key)
    {
        // TODO: throws NOT_IN_COLLECTION exception
        if (isset($this->productCollection[$key])) {
            unset($this->productCollection[$key]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * reset the collection content
     */
    public function reset()
    {
        $this->productCollection = array();
    }

    /**
     * generates unique product id based on productId and features
     *
     * @param $productId
     * @param array $attributes
     */
    private function generateKey($productId, $features = array())
    {
        $key = $productId;
        // sort features
        if (!empty($features)) {
            asort($features);
            // TODO: check the case where the features value is a text string or uploaded file
            $key .= implode('_', $features);
        }

        return md5($key);
    }
}
