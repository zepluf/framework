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
use Zepluf\Bundle\StoreBundle\Entity\ShipmentRouteSegment;
use Zepluf\Bundle\StoreBundle\Entity\ShipmentStatus;
use Zepluf\Bundle\StoreBundle\Event\InventoryAdjustmentEvent;

/**
 *
 */
class Shipment
{
    protected $entityManager;
    protected $dispatcher;
    protected $shipment;

    /**
     * Constructor
     * @param EntityManager $entityManager
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EntityManager $entityManager, EventDispatcherInterface $dispatcher)
    {
        $this->entityManager = $entityManager;
        $this->dispatcher = $dispatcher;
        $this->shipment = new ShipmentEntity();
    }

    /**
     * Create shipment
     * @param $shipmentInfo
     * @param $items
     * @throws \Exception
     */
    public function create($shipmentInfo, $items)
    {
        $error = false;

        $this->initShipment($shipmentInfo);
        $this->initItems($items);

        /**
         * Create Shipment Status
         */
        $shipmentStatus = new ShipmentStatus();
        $shipmentStatus->setShipment($this->shipment)
            ->setShipmentStatusType($this->entityManager->getReference('StoreBundle:ShipmentStatusType', 1));
        $this->shipment->addShipmentStatus($shipmentStatus);

        if (!$error) {
            // save the shipment
            $this->entityManager->persist($this->shipment);
            $this->entityManager->getConnection()->beginTransaction(); // suspend auto-commit
            try {
                $this->entityManager->flush();
                $this->entityManager->getConnection()->commit();
            } catch (\Exception $e) {
                $this->entityManager->getConnection()->rollback();
                $this->entityManager->close();
                throw $e;
            }
            //TODO: Create adjustment
//            $inventoryAdjustmentEvent = new InventoryAdjustmentEvent($this->shipment->getId());
//            $this->dispatcher->dispatch(ComponentEvents::onInventoryAdjust, $inventoryAdjustmentEvent);
        }
    }


    /**
     * @param $shipment
     * @param null $trackId
     */
    public function createRouteSegment($shipment, $trackId = null)
    {
        //  Received Id
        if (is_int($shipment)) {
            $shipmentEntity = $this->entityManager->getReference('StoreBundle:Shipment', $shipment);
        } elseif ($shipment instanceof ShipmentEntity) {
            $shipmentEntity = $shipment;
        }
        $routeSegment = new ShipmentRouteSegment();
        $routeSegment->setShipment($shipmentEntity)
            ->setTrackId($trackId);

        $this->entityManager->persist($routeSegment);
    }

    public function createShipmentStatus()
    {

    }

    /**
     * Initialize shipment info
     * @param array $info
     */
    protected function initShipment($info)
    {
        $shippedFromContactMechanism = $this->entityManager->getReference('StoreBundle:ContactMechanism', (int)$info['shippedFromContactMechanism']);
        $shippedToContactMechanism = $this->entityManager->getReference('StoreBundle:ContactMechanism', (int)$info['shippedToContactMechanism']);
        $shippedFromParty = $this->entityManager->getReference('StoreBundle:Party', (int)$info['shippedFromParty']);
        $shippedToParty = $this->entityManager->getReference('StoreBundle:Party', (int)$info['shippedToParty']);

//        $shipment->setShippedFromContactMechanism($shippedFromContactMechanism)
//            ->setShippedToContactMechanism($shippedToContactMechanism)
//            ->setShippedFromParty($shippedFromParty)
//            ->setShippedToParty($shippedToParty);

        $this->shipment->setIncrementId($this->generateRandomString());
        $this->shipment->setShipCost($info['shipCost']);
        $this->shipment->setTotalWeight($info['totalWeight']);

        //  Set shipment type, outgoing shipment is default
        if (isset($info['shipmentType']) || !empty($info['shipmentType'])) {
            $this->shipment->setShipmentType($info['shipmentType']);
        } else {
            $this->shipment->setShipmentType((int)ShipmentType::CUSTOMER_SHIPMENT);
        }

        $handlingInstruction = $info['handlingInstruction'];
        $this->shipment->setHandlingInstructions($handlingInstruction);
    }

    /**
     *  Initialize shipment items
     * @param array $items
     */
    protected function initItems($items)
    {
        //  Record items to shipment_item table
        foreach ($items as $item) {
            $shipmentItem = new ShipmentItem();

            $shipmentItem
                ->setQuantity($item['quantity'])
                ->setDescription($item['description'])
                ->setProduct($this->entityManager->getReference('StoreBundle:Product', (int)$item['productId']))
                ->setShipment($this->shipment);

            /**
             * Record features to shipment_item_feature table
             */
            foreach ($item['features'] as $feature) {
                $shipmentItemFeature = new ShipmentItemFeature();

                $shipmentItemFeature
                    ->setShipmentItem($shipmentItem)
                    ->setProductFeatureApplication($this->entityManager->getReference('StoreBundle:ProductFeatureApplication', (int)$feature['productFeatureApplicationId']))
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
            $this->shipment->addShipmentItem($shipmentItem);
        }
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
}
