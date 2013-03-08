<?php
/**
 * Created by Rubikin Team.
 * Date: 3/4/13
 * Time: 5:41 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Cart;

use Zepluf\Bundle\StoreBundle\Component\Cart\StorageHandler\StorageHandlerInterface;
use Zepluf\Bundle\StoreBundle\Component\Product\ProductCollection;

class Cart
{
    protected $storageHandler;

    /**
     * List of product in shopping cart
     *
     * @var array|null
     */
    protected $productCollection;

    /**
     * sets storage handler
     *
     * @param StorageHandlerInterface $storageHandler
     */
    public function setStorageHandler(StorageHandlerInterface $storageHandler)
    {
        $this->storageHandler = $storageHandler;
    }

    /**
     * List of shopping cart items
     *
     * @return ProductCollection
     */
    public function getProductCollection()
    {
        return $this->productCollection;
    }

    /**
     * adds item into cart
     *
     * @param $productId
     * @param int $quantity
     * @param array $features
     * @return Cart
     */
    public function add($productId, $quantity = 1, $features = array())
    {
        // TODO: check for conditions

        $this->productCollection->add($productId, $quantity, $features);
        return $this;
    }

    /**
     * updates item in cart
     *
     * @param $key
     * @param $quantity
     * @return Cart
     */
    public function update($key, $quantity)
    {
        $this->productCollection->update($key, $quantity);
        return $this;
    }

    /**
     * Removes item from cart
     *
     * @param   string $key
     * @return  Cart
     */
    public function remove($key)
    {
        $this->productCollection->remove($key);
        return $this;
    }

    /**
     * Empties shopping cart
     *
     * @return Cart
     */
    public function reset()
    {
        $this->productCollection->reset();
        return $this;
    }

    /**
     * Saves cart
     *
     * @return Cart
     */
    public function save()
    {
        $this->storageHandler->save($this->productCollection);
    }

    public function setProductCollection(ProductCollection $productCollection)
    {
        $this->productCollection = $productCollection;
    }
}