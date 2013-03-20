<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderStatus
 *
 * @ORM\Table(name="order_status")
 * @ORM\Entity
 */
class OrderStatus
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
     * @ORM\Column(name="entry_date", type="datetime", nullable=false)
     */
    private $entryDate;

    /**
     * @var \Order
     *
     * @ORM\ManyToOne(targetEntity="Order")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * })
     */
    private $order;

    /**
     * @var \OrderStatusType
     *
     * @ORM\ManyToOne(targetEntity="OrderStatusType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_status_type_id", referencedColumnName="id")
     * })
     */
    private $orderStatusType;

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
     * Set entryDate
     *
     * @param \DateTime $entryDate
     * @return OrderStatus
     */
    public function setEntryDate($entryDate)
    {
        $this->entryDate = $entryDate;
    
        return $this;
    }

    /**
     * Get entryDate
     *
     * @return \DateTime 
     */
    public function getEntryDate()
    {
        return $this->entryDate;
    }

    /**
     * Set order
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Order $order
     * @return OrderStatus
     */
    public function setOrder(\Zepluf\Bundle\StoreBundle\Entity\Order $order = null)
    {
        $this->order = $order;
    
        return $this;
    }

    /**
     * Get order
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Order 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set orderStatusType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\OrderStatusType $orderStatusType
     * @return OrderStatus
     */
    public function setOrderStatusType(\Zepluf\Bundle\StoreBundle\Entity\OrderStatusType $orderStatusType = null)
    {
        $this->orderStatusType = $orderStatusType;
    
        return $this;
    }

    /**
     * Get orderStatusType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\OrderStatusType 
     */
    public function getOrderStatusType()
    {
        return $this->orderStatusType;
    }

    /**
     * Set orderItem
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\OrderItem $orderItem
     * @return OrderStatus
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