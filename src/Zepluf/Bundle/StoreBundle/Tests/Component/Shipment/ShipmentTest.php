<?php
/**
 * Created by Rubikin Team.
 * Date: 3/25/13
 * Time: 11:05 AM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Tests\Component\Shipment;

use Zepluf\Bundle\StoreBundle\Component\Shipment\Shipment;
use Zepluf\Bundle\StoreBundle\Tests\BaseTestCase;

class ShipmentTest extends BaseTestCase
{
    protected $obj;

    public function testCreateShipment()
    {
        $entityManager = $this->get('doctrine.orm.entity_manager');
        $eventDispatcher = $this->get('event_dispatcher');

        $this->obj = new Shipment($entityManager, $eventDispatcher);

        $info = array(
            'shippedFromContactMechanism' => 1,
            'shippedToContactMechanism' => 2,
            'shippedFromParty' => 1,
            'shippedToParty' => 2,
            'handlingInstruction' => 'Fragile',
            'shipCost' => 500,
            'totalWeight' => 2
        );

        $items = array();
        $items[] = array(
            'id' => 1,
            'quantity' => 10,
            'description' => "iPhone 5",
            'productId' => 1,
            'shipped' => 10,
            'features' => array(
                array(
                    'productFeatureApplicationId' => 1,
                    'name' => 'Color',
                    'value' => 'Black'),
                array(
                    'productFeatureApplicationId' => 2,
                    'name' => 'Color',
                    'value' => 'White'),
                array(
                    'productFeatureApplicationId' => 3,
                    'name' => 'Storage',
                    'value' => '8GB'),
                array(
                    'productFeatureApplicationId' => 4,
                    'name' => 'Storage',
                    'value' => '16GB'),
            )
        );

        $this->obj->create($info, $items);
    }

    protected function getEntityManager()
    {
        $obj = $this->getMock('Doctrine\ORM\EntityManager', array('getReference', 'persist', 'flush'));
        $obj->expects($this->any())
            ->method('flush')
            ->will($this->returnValue(true));
        return $obj;
    }

    protected function getEventDispatcher()
    {
        $obj = $this->getMock('Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher');

        return $obj;
    }
}