<?php
/**
 * Created by Rubikin Team.
 * Date: 3/15/13
 * Time: 12:16 AM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Price;

class TaxPriceHandler implements PriceHandlerInterface
{
    public function getCode()
    {
        return 'Tax';
    }

    public function getTag()
    {
        return 'Tax';
    }

    public function getPrice($currentPrice, \Zepluf\Bundle\StoreBundle\Entity\PriceComponent $priceComponent)
    {
        return $currentPrice + ($currentPrice * $priceComponent->getValue() / 100);
    }
}
