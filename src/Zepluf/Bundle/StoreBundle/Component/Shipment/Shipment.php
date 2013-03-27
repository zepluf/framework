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
use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\ORMException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Zepluf\Bundle\StoreBundle\ComponentEvents;
use Zepluf\Bundle\StoreBundle\Entity\Shipment as ShipmentEntity;
use Zepluf\Bundle\StoreBundle\Entity\ShipmentItem;
use Zepluf\Bundle\StoreBundle\Entity\OrderShipment;
use Zepluf\Bundle\StoreBundle\Entity\ShipmentItemFeature;
use Zepluf\Bundle\StoreBundle\Entity\ShipmentRouteSegment;
use Zepluf\Bundle\StoreBundle\Entity\ShipmentStatus;
use Zepluf\Bundle\StoreBundle\Entity\ShipmentStatusType;
use Zepluf\Bundle\StoreBundle\Event\InventoryAdjustmentEvent;


/**
 *  Shipment Component Class
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
    }

    /**
     * Set Shipment
     * @param \Zepluf\Bundle\StoreBundle\Entity\Shipment $shipment
     * @return $this
     */
    public function setShipment($shipment)
    {
        $this->shipment = $shipment;

        return $this;
    }

    /**
     * Get Shipment
     * @return \Zepluf\Bundle\StoreBundle\Entity\Shipment
     */
    public function getShipment()
    {
        return $this->shipment;
    }

    /**
     * Creates shipment
     * @param $shipmentInfo
     * @param $items
     * @return bool|string
     * @throws \Exception
     */
    public function create($shipmentInfo, $items)
    {
        $error = false;
        $this->shipment = new ShipmentEntity();

        $this->initShipment($shipmentInfo);
        $this->initItems($items);

        /**
         * Create Shipment Status
         */
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
            $inventoryAdjustmentEvent = new InventoryAdjustmentEvent($this->shipment->getId());
            $this->dispatcher->dispatch(ComponentEvents::onInventoryAdjust, $inventoryAdjustmentEvent);

            return $this->shipment->getIncrementId();
        } else {
            return false;
        }
    }

    /**
     * Creates a shipment route segment
     * @param $shipment
     * @param null $trackId
     * @param bool $flush
     * @return ShipmentRouteSegment
     * @throws \Doctrine\DBAL\ConnectionException|\Exception
     * @throws \Doctrine\ORM\ORMException|\Exception
     */
    public function createRouteSegment($shipment, $trackId = null, $flush = true)
    {
        //  Received Id
        try {
            if (is_int($shipment)) {
                $shipmentEntity = $this->entityManager->getReference('StoreBundle:Shipment', $shipment);
            } elseif ($shipment instanceof ShipmentEntity) {
                $shipmentEntity = $shipment;
            }
            $routeSegment = new ShipmentRouteSegment();
            $routeSegment->setShipment($shipmentEntity)
                ->setTrackId($trackId);

            if ($flush) {
                $this->entityManager->persist($this->$routeSegment);
                $this->entityManager->getConnection()->beginTransaction(); // suspend auto-commit
                $this->entityManager->flush();
                $this->entityManager->getConnection()->commit();
            } else {
                return $routeSegment;
            }
        } catch (ORMException $e) {
            throw $e;
        }
        catch (ConnectionException $e) {
            $this->entityManager->getConnection()->rollback();
            $this->entityManager->close();
            throw $e;
        }
    }

    /**
     * Creates a shipment status
     * @param $shipment
     * @param int $statusType
     * @param bool $flush
     * @return ShipmentStatus
     * @throws \Doctrine\DBAL\ConnectionException|\Exception
     * @throws \Doctrine\ORM\ORMException|\Exception
     */
    public function createShipmentStatus($shipment, $statusType = 1, $flush = true)
    {
        try {
            if (is_int($shipment)) {
                $shipmentEntity = $this->entityManager->getReference('StoreBundle:Shipment', $shipment);
            } elseif ($shipment instanceof ShipmentEntity) {
                $shipmentEntity = $shipment;
            }

            if (is_int($statusType)) {
                $shipmentEntity = $this->entityManager->getReference('StoreBundle:Shipment', $statusType);
            } elseif ($statusType instanceof ShipmentStatusType) {
                $shipmentStatusType = $statusType;
            }

            $shipmentStatus = new ShipmentStatus();
            $shipmentStatus->setShipment($shipmentEntity)
                ->setShipmentStatusType($shipmentStatusType);

            if ($flush) {
                $this->entityManager->persist($this->$shipmentStatus);
                $this->entityManager->getConnection()->beginTransaction(); // suspend auto-commit
                $this->entityManager->flush();
                $this->entityManager->getConnection()->commit();
            } else {
                return $shipmentStatus;
            }
        } catch (ORMException $e) {
            throw $e;
        }
        catch (ConnectionException $e) {
            $this->entityManager->getConnection()->rollback();
            $this->entityManager->close();
            throw $e;
        }
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

        $this->shipment->setShippedFromContactMechanism($shippedFromContactMechanism)
            ->setShippedToContactMechanism($shippedToContactMechanism)
            ->setShippedFromParty($shippedFromParty)
            ->setShippedToParty($shippedToParty);

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
        $this->shipment = new ShipmentEntity();

//        $shipmentStatus = $this->createShipmentStatus($this->shipment, null, false);
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
