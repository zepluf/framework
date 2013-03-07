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

class Cart
{
    protected $storageHandler;

    /**
     * List of product in shopping cart
     *
     * @var array|null
     */
    protected $productList;

    public function __construct()
    {
    }

    public function addProduct($productId, $quantity = 1, $features = array())
    {
        return $this;
    }

    /**
     * List of shopping cart items
     *
     * @return ProductCollection
     */
    public function getProductList()
    {
        return $this->productCollection;
    }

    protected function getProduct()
    {

    }

    public function update($productId, $productId, $features = array())
    {
    }

    /**
     * Remove item from cart
     *
     * @param   int $productId
     * @return  Cart
     */
    public function remove($productId)
    {
//        $this->getSessionCart()
        return $this;
    }

    /**
     * Save cart
     *
     * @return Cart
     */
    public function save()
    {

    }

    /**
     * Empty shopping cart
     *
     * @return Cart
     */
    public function truncate()
    {
        $this->getSessionCart()->removeAll();
        return $this;
    }

    protected function getSessionCart()
    {
        //TODO: get session cart object
        return $_SESSION['cart'];
    }

    public function setStorageHandler(StorageHandler\StorageHandlerInterface $storageHandler)
    {
        $this->storageHandler = $storageHandler;
    }
}
