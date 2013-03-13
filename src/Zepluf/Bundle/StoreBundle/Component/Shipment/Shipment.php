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
use Zepluf\Bundle\StoreBundle\Component\Shipment\Carrier\ShippingMethodInterface;

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

    /**
     * Constructor
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $data ('shipment' => array(), 'shipment_item' => array(). ...)
     * @throws \Exception
     */
    public function create($data)
    {
        $error = false;

        //Init logic code
        $shipment = new ShipmentEntity();
        // set the shipment timestamp
        $shipment->setCreatedAt(new \DateTime());
        $shipment->setUpdatedAt(new \DateTime());

        //If ship from address is empty, it's shopkeeper contact by default
        if (isset($data['ShippedFromContactMechanism'])) {
            $shipment->setShippedFromContactMechanism($data['ship_from']);
        }
        if (isset($data['ship_from'])) {
            $shipment->setShippedToContactMechanism($data['ship_to']);
        }


        //set Shipment Item
        foreach ($data['items'] as $item) {
            $shipmentItem = new ShipmentItem();

            //logical code to set info for ShipmentItem

            $shipmentItem->setShipment($shipment);
            $shipment->addShipmentItem($shipmentItem);
        }

        if (!$error) {
            $this->shipment = $shipment;
        }

        if ($this->shipment) {
            // persists the shipment
            $this->entityManager->persist($this->shipment);
            try {
                $this->entityManager->flush();
            } catch (\Exception $e) {
                throw $e;
            }
        }


    }

    /**
     * Initialize shipment model
     * @param $data
     */
    protected function initShipment($data)
    {
        $error = false;

        //Init logic code
        $shipment = new ShipmentEntity();
        // set the shipment timestamp
        $shipment->setCreatedAt(new \DateTime());
        $shipment->setUpdatedAt(new \DateTime());

        //If ship from address is empty, it's shopkeeper contact by default
        if (isset($data['ShippedFromContactMechanism'])) {
            $shipment->setShippedFromContactMechanism($data['ship_from']);
        }
        if (isset($data['ship_from'])) {
            $shipment->setShippedToContactMechanism($data['ship_to']);
        }


        //set Shipment Item
        foreach ($data['items'] as $item) {
            $shipmentItem = new ShipmentItem();

            //logical code to set info for ShipmentItem

            $shipmentItem->setShipment($shipment);
            $shipment->addShipmentItem($shipmentItem);
        }

        if (!$error) {
            $this->shipment = $shipment;
        }
    }
}
