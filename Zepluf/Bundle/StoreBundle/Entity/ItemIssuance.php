<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItemIssuance
 *
 * @ORM\Table(name="item_issuance")
 * @ORM\Entity
 */
class ItemIssuance
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
     * @ORM\Column(name="issued_date", type="datetime", nullable=true)
     */
    private $issuedDate;

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
     * @return ItemIssuance
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
     * @return ItemIssuance
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
     * Set issuedDate
     *
     * @param \DateTime $issuedDate
     * @return ItemIssuance
     */
    public function setIssuedDate($issuedDate)
    {
        $this->issuedDate = $issuedDate;
    
        return $this;
    }

    /**
     * Get issuedDate
     *
     * @return \DateTime 
     */
    public function getIssuedDate()
    {
        return $this->issuedDate;
    }

    /**
     * Set shipmentItem
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ShipmentItem $shipmentItem
     * @return ItemIssuance
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
     * @return ItemIssuance
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
}