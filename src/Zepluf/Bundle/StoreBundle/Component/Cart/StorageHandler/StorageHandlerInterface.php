<?php
/**
 * Created by Rubikin Team.
 * Date: 3/4/13
 * Time: 5:41 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Cart\StorageHandler;

use Zepluf\Bundle\StoreBundle\Component\Product\ProductCollection;

interface StorageHandlerInterface
{
    /**
     * saves the collection
     *
     * @param \Zepluf\Bundle\StoreBundle\Component\Product\ProductCollection $productCollection
     * @return mixed
     */
    public function save(ProductCollection $productCollection);

    /**
     * gets the collection
     *
     * @return Zepluf\Bundle\StoreBundle\Component\Product\ProductCollection $productCollection
     */
    public function retrieve();
}
