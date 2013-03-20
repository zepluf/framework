<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryItemVariance
 *
 * @ORM\Table(name="inventory_item_variance")
 * @ORM\Entity
 */
class InventoryItemVariance
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

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
     * @var \InventoryItemVarianceReason
     *
     * @ORM\ManyToOne(targetEntity="InventoryItemVarianceReason")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inventory_item_variance_reason_id", referencedColumnName="id")
     * })
     */
    private $inventoryItemVarianceReason;



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
     * Set date
     *
     * @param \DateTime $date
     * @return InventoryItemVariance
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
     * Set quantity
     *
     * @param integer $quantity
     * @return InventoryItemVariance
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
     * Set comment
     *
     * @param string $comment
     * @return InventoryItemVariance
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    
        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set inventoryItem
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\InventoryItem $inventoryItem
     * @return InventoryItemVariance
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
     * Set inventoryItemVarianceReason
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\InventoryItemVarianceReason $inventoryItemVarianceReason
     * @return InventoryItemVariance
     */
    public function setInventoryItemVarianceReason(\Zepluf\Bundle\StoreBundle\Entity\InventoryItemVarianceReason $inventoryItemVarianceReason = null)
    {
        $this->inventoryItemVarianceReason = $inventoryItemVarianceReason;
    
        return $this;
    }

    /**
     * Get inventoryItemVarianceReason
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\InventoryItemVarianceReason 
     */
    public function getInventoryItemVarianceReason()
    {
        return $this->inventoryItemVarianceReason;
    }
}