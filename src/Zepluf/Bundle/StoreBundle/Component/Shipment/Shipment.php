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

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Zepluf\Bundle\StoreBundle\ComponentEvents;
use Zepluf\Bundle\StoreBundle\Entity\Picklist;
use Zepluf\Bundle\StoreBundle\Entity\Shipment as ShipmentEntity;
use Zepluf\Bundle\StoreBundle\Entity\ShipmentItem;
use Zepluf\Bundle\StoreBundle\Entity\OrderShipment;
use Zepluf\Bundle\StoreBundle\Entity\ShipmentItemFeature;
use Zepluf\Bundle\StoreBundle\Event\InventoryAdjustmentEvent;

/**
 *
 */
class Shipment
{
    protected $entityManager;
    protected $dispatcher;

    /**
     * Shipment model
     * @var \Zepluf\Bundle\StoreBundle\Entity\Shipment
     */
    protected $shipment = false;

    /**
     * Constructor
     * @param EntityManager $entityManager
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EntityManager $entityManager, EventDispatcherInterface $dispatcher)
    {
        $this->entityManager = $entityManager;
        $this->dispatcher = $dispatcher;
    }

    protected function initShipment($data)
    {
        $shipment = new ShipmentEntity();

        $shippedFromContactMechanism = $this->entityManager->getReference('StoreBundle:ContactMechanism', (int)$data['shippedFromContactMechanism']);
        $shippedToContactMechanism = $this->entityManager->getReference('StoreBundle:ContactMechanism', (int)$data['shippedToContactMechanism']);
        $shippedFromParty = $this->entityManager->getReference('StoreBundle:Party', (int)$data['shippedFromParty']);
        $shippedToParty = $this->entityManager->getReference('StoreBundle:Party', (int)$data['shippedToParty']);

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
     * Create shipment
     * @param array $data ('shipment' => array(), 'shipment_item' => array(). ...)
     * @throws \Exception
     */
    public function create($data)
    {
        $error = false;

        //Init logic code
        $shipment = $this->initShipment($data);

        //  Record items to shipment_item table
        foreach ($data['order_items'] as $item) {
            $shipmentItem = new ShipmentItem();

            $shipmentItem
                ->setQuantity($item['quantity'])
                ->setDescription($item['description'])
                ->setProduct($this->entityManager->getReference('StoreBundle:Product', (int)$item['productId']))
                ->setShipment($shipment);
            $this->entityManager->persist($shipmentItem);

            /**
             * Record features to shipment_item_feature table
             */
            foreach ($item['features'] as $feature) {
                $shipmentItemFeature = new ShipmentItemFeature();

                $shipmentItemFeature
                    ->setShipmentItem($shipmentItem)
                    ->setProductFeatureApplication($this->entityManager->getReference('StoreBundle:ProductFeatureApplicability', (int)$feature['productFeatureApplicabilityId']))
                    ->setName($feature['name'])
                    ->setValue($feature['value']);

                $this->entityManager->persist($shipmentItemFeature);

                //Add to Features list of Shipment item
                $shipmentItem->addFeature($shipmentItemFeature);
            }

            /**
             * Create reference relation with order item
             */
            $shipmentOrder = new OrderShipment();

            $shipmentOrder->setOrderItem($this->entityManager->getReference('StoreBundle:OrderItem', (int)$item['id']))
                ->setShipmentItem($shipmentItem)
                ->setShippedQuantity($item['shipped']);
            $this->entityManager->persist($shipmentOrder);

            /**
             * Add to Shipment Item list of Shipment
             */
            $shipment->addShipmentItem($shipmentItem);
        }

        if (!$error) {
            // save the shipment
            $this->entityManager->persist($shipment);
            try {
                $this->entityManager->flush();

                //TODO: Create adjustment
                $inventoryAdjustmentEvent = new InventoryAdjustmentEvent($shipment->getId());
                $this->dispatcher->dispatch(ComponentEvents::onInventoryAdjust, $inventoryAdjustmentEvent);
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }
}
