<?php
/**
 * Created by Rubikin Team.
 * Date: 3/17/13
 * Time: 11:44 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Price\Handler;

interface ProductPriceHandlerInterface
{
    /**
     * Calculate the price
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\PriceComponent $priceComponent
     * @return decimal
     */
    public function getPrice($currentPrice, \Zepluf\Bundle\StoreBundle\Entity\PriceComponent $priceComponent, \Zepluf\Bundle\StoreBundle\Entity\Product $product);
}
