<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderShipment
 *
 * @ORM\Table(name="order_shipment")
 * @ORM\Entity
 */
class OrderShipment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="shipped_quantity", type="integer", nullable=true)
     */
    private $shippedQuantity;

    /**
     * @var \ShipmentItem
     *
     * @ORM\ManyToOne(targetEntity="ShipmentItem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipment_item_id", referencedColumnName="id")
     * })
     */
    private $shipmentItem;

    /**
     * @var \OrderItem
     *
     * @ORM\ManyToOne(targetEntity="OrderItem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_item_id", referencedColumnName="id")
     * })
     */
    private $orderItem;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set shippedQuantity
     *
     * @param integer $shippedQuantity
     * @return OrderShipment
     */
    public function setShippedQuantity($shippedQuantity)
    {
        $this->shippedQuantity = $shippedQuantity;
    
        return $this;
    }

    /**
     * Get shippedQuantity
     *
     * @return integer 
     */
    public function getShippedQuantity()
    {
        return $this->shippedQuantity;
    }

    /**
     * Set shipmentItem
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ShipmentItem $shipmentItem
     * @return OrderShipment
     */
    public function setShipmentItem(\Zepluf\Bundle\StoreBundle\Entity\ShipmentItem $shipmentItem = null)
    {
        $this->shipmentItem = $shipmentItem;
    
        return $this;
    }

    /**
     * Get shipmentItem
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ShipmentItem 
     */
    public function getShipmentItem()
    {
        return $this->shipmentItem;
    }

    /**
     * Set orderItem
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\OrderItem $orderItem
     * @return OrderShipment
     */
    public function setOrderItem(\Zepluf\Bundle\StoreBundle\Entity\OrderItem $orderItem = null)
    {
        $this->orderItem = $orderItem;
    
        return $this;
    }

    /**
     * Get orderItem
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\OrderItem 
     */
    public function getOrderItem()
    {
        return $this->orderItem;
    }
}