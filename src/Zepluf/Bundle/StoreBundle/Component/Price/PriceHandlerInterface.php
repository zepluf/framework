<?php
/**
 * Created by Rubikin Team.
 * Date: 3/4/13
 * Time: 5:41 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Price;

interface PriceHandlerInterface
{
    /**
     * Get handler unique code name
     *
     * @return string
     */
    public function getCode();

    /**
     * Get the handler tag
     *
     * @return mixed
     */
    public function getTag();

    /**
     * Calculate the price
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\PriceComponent $priceComponent
     * @return decimal
     */
    public function getPrice($currentPrice, \Zepluf\Bundle\StoreBundle\Entity\PriceComponent $priceComponent);
}
