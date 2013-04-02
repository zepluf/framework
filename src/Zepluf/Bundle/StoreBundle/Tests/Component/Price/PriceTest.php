<?php
/**
 * Created by Rubikin Team.
 * Date: 3/22/13
 * Time: 2:37 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Zepluf\Bundle\StoreBundle\Tests\Component\Price\Handler;

use Zepluf\Bundle\StoreBundle\Component\Price\Price;
use Zepluf\Bundle\StoreBundle\Tests\BaseTestCase;

class PriceTest extends BaseTestCase{

    public function testAddComponent()
    {
        $price = new Price();
        $price->addComponent('test', 'test', 'test', 10);
        $price->addComponent('test2', 'test2', 'test2', 10);

        $this->assertEquals(20, $price->getTotal());

    }
}