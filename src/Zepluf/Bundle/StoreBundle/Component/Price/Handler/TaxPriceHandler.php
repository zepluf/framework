<?php
/**
 * Created by Rubikin Team.
 * Date: 3/15/13
 * Time: 12:16 AM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Price\Handler;

use Zepluf\Bundle\StoreBundle\Entity\PriceComponent as PriceComponentEntity;

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

    public function getPrice($currentPrice, PriceComponentEntity $priceComponent)
    {
        return $currentPrice * $priceComponent->getValue() / 100;
    }
}
