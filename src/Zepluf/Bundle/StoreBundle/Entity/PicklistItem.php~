<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PicklistItem
 *
 * @ORM\Table(name="picklist_item")
 * @ORM\Entity
 */
class PicklistItem
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
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     */
    private $quantity;

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
     * @var \Picklist
     *
     * @ORM\ManyToOne(targetEntity="Picklist")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="picklist_id", referencedColumnName="id")
     * })
     */
    private $picklist;



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
     * Set quantity
     *
     * @param integer $quantity
     * @return PicklistItem
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
     * Set inventoryItem
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\InventoryItem $inventoryItem
     * @return PicklistItem
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
     * Set picklist
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Picklist $picklist
     * @return PicklistItem
     */
    public function setPicklist(\Zepluf\Bundle\StoreBundle\Entity\Picklist $picklist = null)
    {
        $this->picklist = $picklist;
    
        return $this;
    }

    /**
     * Get picklist
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Picklist 
     */
    public function getPicklist()
    {
        return $this->picklist;
    }
}