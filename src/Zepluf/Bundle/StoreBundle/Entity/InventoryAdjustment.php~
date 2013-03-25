<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryAdjustment
 *
 * @ORM\Table(name="inventory_adjustment")
 * @ORM\Entity
 */
class InventoryAdjustment
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
     * @ORM\Column(name="increment_id", type="integer", nullable=false)
     */
    private $incrementId;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

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
     * @var \InventoryItem
     *
     * @ORM\ManyToOne(targetEntity="InventoryItem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inventory_item_id", referencedColumnName="id")
     * })
     */
    private $inventoryItem;

    /**
     * @var \PicklistItem
     *
     * @ORM\ManyToOne(targetEntity="PicklistItem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="picklist_item_id", referencedColumnName="id")
     * })
     */
    private $picklistItem;



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
     * Set incrementId
     *
     * @param integer $incrementId
     * @return InventoryAdjustment
     */
    public function setIncrementId($incrementId)
    {
        $this->incrementId = $incrementId;
    
        return $this;
    }

    /**
     * Get incrementId
     *
     * @return integer 
     */
    public function getIncrementId()
    {
        return $this->incrementId;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return InventoryAdjustment
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return InventoryAdjustment
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set shipmentItem
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ShipmentItem $shipmentItem
     * @return InventoryAdjustment
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
     * Set inventoryItem
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\InventoryItem $inventoryItem
     * @return InventoryAdjustment
     */
    public function setInventoryItem(\Zepluf\Bundle\StoreBundle\Entity\InventoryItem $inventoryItem = null)
    {
        $this->inventoryItem = $inventoryItem;
    
        return $this;
    }

    /**
     * Get inventoryItem
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\InventoryItem 
     */
    public function getInventoryItem()
    {
        return $this->inventoryItem;
    }

    /**
     * Set picklistItem
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\PicklistItem $picklistItem
     * @return InventoryAdjustment
     */
    public function setPicklistItem(\Zepluf\Bundle\StoreBundle\Entity\PicklistItem $picklistItem = null)
    {
        $this->picklistItem = $picklistItem;
    
        return $this;
    }

    /**
     * Get picklistItem
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\PicklistItem 
     */
    public function getPicklistItem()
    {
        return $this->picklistItem;
    }
}