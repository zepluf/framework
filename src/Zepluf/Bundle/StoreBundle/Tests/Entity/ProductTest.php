<?php
/**
 * Created by Rubikin Team.
 * Date: 3/9/13
 * Time: 10:50 AM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Tests\Entity;

use Zepluf\Bundle\StoreBundle\Tests\BaseTestCase;

class ProductTest extends BaseTestCase
{
    public function setUp()
    {

    }

    public function testGetPrice()
    {
        $em = $this->_container->get('doctrine.orm.entity_manager');
        $product = $em->find('Zepluf\Bundle\StoreBundle\Entity\Product', 1);

        $pricing = new \Zepluf\Bundle\StoreBundle\Component\Price\Pricing();
        $pricing->addHandler(new \Zepluf\Bundle\StoreBundle\Component\Price\DefaultPriceHandler());
        var_dump($pricing->getProductPrice($product));
        die();
    }
}
