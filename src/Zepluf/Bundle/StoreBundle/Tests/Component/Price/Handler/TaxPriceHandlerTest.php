<?php
/**
 * Created by Rubikin Team.
 * Date: 3/21/13
 * Time: 4:19 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Zepluf\Bundle\StoreBundle\Tests\Component\Price\Handler;

use Zepluf\Bundle\StoreBundle\Component\Price\Handler\TaxPriceHandler;
use Zepluf\Bundle\StoreBundle\Tests\BaseTestCase;

class TaxPriceHandlerTest extends BaseTestCase{

    public function testGetPrice()
    {
        $priceComponent = $this->getMock('Zepluf\Bundle\StoreBundle\Entity\PriceComponent');

        $priceComponent->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue(10));

        $taxPriceHandler = new TaxPriceHandler();

        // Value is 10, tax is 10% then the tax amount should be 1
        $this->assertEquals(1, $taxPriceHandler->getPrice(10, $priceComponent));
    }
}