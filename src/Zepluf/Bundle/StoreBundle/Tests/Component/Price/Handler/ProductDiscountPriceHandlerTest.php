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

use Zepluf\Bundle\StoreBundle\Tests\BaseTestCase;

class ProductDiscountPriceHandlerTest extends BaseTestCase{

    public function testCategoryDiscount()
    {
        $product = $this->getMock('Zepluf\Bundle\StoreBundle\Entity\Product');

//        $product->expects($this->once())
//            ->method('isChildOf')
//            ->with($this->equalTo(1))
//            ->will($this->returnValue(true));

        $priceComponent = $this->getMock('Zepluf\Bundle\StoreBundle\Entity\PriceComponent');

        $priceComponent->expects($this->once())
            ->method('getSetting')
            ->with($this->equalTo('category'))
            ->will($this->returnValue(array('categoryIds' => array(1,2,3), 'type' => 1)));

        $priceComponent->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue(10));

        $productComponent = $this->getMockBuilder('Zepluf\Bundle\StoreBundle\Component\Product\ProductComponent')
            ->disableOriginalConstructor()
            ->getMock();

        $productComponent->expects($this->any())
            ->method('isChildOf')
            ->with($this->logicalOr(
                $this->equalTo(1),
                $this->equalTo(2),
                $this->equalTo(3)
            ))
            ->will($this->returnCallback(array($this, 'isChildOf')));

        $productComponent->expects($this->once())
            ->method('setProduct')
            ->will($this->returnValue($productComponent));

        $productDiscountPriceHandler = new \Zepluf\Bundle\StoreBundle\Component\Price\Handler\ProductDiscountPriceHandler($productComponent);

        $this->assertEquals(9, $productDiscountPriceHandler->getPrice(10, $priceComponent, $product));
    }

    public function isChildOf($id)
    {
        if(1 == $id) {
            return true;
        }

        return false;
    }

}