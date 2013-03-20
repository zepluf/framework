<?php
/**
 * Created by Rubikin Team.
 * Date: 3/7/13
 * Time: 7:00 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Shipment;

use Zepluf\Bundle\StoreBundle\Entity\Shipment as ShipmentEntity;
use Zepluf\Bundle\StoreBundle\Entity\ShipmentItem;
use Zepluf\Bundle\StoreBundle\Entity\OrderShipment;
use Zepluf\Bundle\StoreBundle\Component\Shipment\Carrier\ShippingCarrierInterface;

/**
 *
 */
class Shipment
{
    protected $entityManager;

    /**
     * Shipment model
     * @var \Zepluf\Bundle\StoreBundle\Entity\Shipment
     */
    protected $shipment = false;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function initShipment($data)
    {
        $shipment = new ShipmentEntity();

        $shippedFromContactMechanism = $this->entityManager->find('StoreBundle:ContactMechanism', (int)$data['shippedFromContactMechanism']);
        $shippedToContactMechanism = $this->entityManager->find('StoreBundle:ContactMechanism', (int)$data['shippedToContactMechanism']);
        $shippedFromParty = $this->entityManager->find('StoreBundle:Party', (int)$data['shippedFromParty']);
        $shippedToParty = $this->entityManager->find('StoreBundle:Party', (int)$data['shippedToParty']);

        $shipment->setShippedFromContactMechanism($shippedFromContactMechanism)
            ->setShippedToContactMechanism($shippedToContactMechanism)
            ->setShippedFromParty($shippedFromParty)
            ->setShippedToParty($shippedToParty);

        $shipment->setIncrementId($this->generateRandomString());

        $handlingInstruction = $data['handlingInstruction'];
        $shipment->setHandlingInstructions($handlingInstruction);

        return $shipment;
    }

    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    /**
     * @param array $data ('shipment' => array(), 'shipment_item' => array(). ...)
     * @throws \Exception
     */
    public function create($data)
    {
        $error = false;

        //Init logic code
        $shipment = $this->initShipment($data);

        //set Shipment Item
        foreach ($data['order_items'] as $item) {
            $shipmentItem = new ShipmentItem();
//            foreach ($item as $property => $value) {
//                // create a setter
//                $method = sprintf('set%s', ucwords($property)); // or you can cheat and omit ucwords() because PHP method calls are case insensitive
//                // use the method as a variable variable to set your value
//                $shipmentItem->$method($value);
//            }
            $product = $this->entityManager->find('StoreBundle:Product', (int)$item['productId']);

            $shipmentItem->setQuantity($item['quantity'])
                ->setDescription($item['description'])
                ->setProduct($product)
                ->setShipment($shipment);

            $this->entityManager->persist($shipmentItem);

            //Create reference relation with order item
            $shipmentOrder = new OrderShipment();
            $orderItem = $this->entityManager->find('StoreBundle:OrderItem', (int)$item['id']);

            $shipmentOrder->setOrderItem($orderItem)
                ->setShipmentItem($shipmentItem)
                ->setShippedQuantity($item['shipped']);

            $this->entityManager->persist($shipmentOrder);

            $shipment->addShipmentItem($shipmentItem);
        }

        if (!$error) {
            // save the shipment
            $this->entityManager->persist($shipment);
            try {
                $this->entityManager->flush();
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }

}
