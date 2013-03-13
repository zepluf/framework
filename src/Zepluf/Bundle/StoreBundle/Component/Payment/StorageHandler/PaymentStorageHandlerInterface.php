<?php
/**
 * Created by Rubikin Team.
 * Date: 3/4/13
 * Time: 5:41 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Payment\StorageHandler;

interface PaymentStorageHandlerInterface
{
    /**
     * saves the payment method
     *
     * @param \Zepluf\Bundle\StoreBundle\Component\Product\ProductCollection $productCollection
     *
     * @return mixed
     */
    public function set();

    /**
     * gets the payment method
     *
     * @return Zepluf\Bundle\StoreBundle\Component\Product\ProductCollection $productCollection
     */
    public function retrieve();
}
