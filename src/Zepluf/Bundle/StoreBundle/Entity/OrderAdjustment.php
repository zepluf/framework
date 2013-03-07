<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderAdjustment
 *
 * @ORM\Table(name="order_adjustment")
 * @ORM\Entity
 */
class OrderAdjustment
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
     * @var float
     *
     * @ORM\Column(name="amount", type="decimal", nullable=true)
     */
    private $amount;

    /**
     * @var float
     *
     * @ORM\Column(name="percentage", type="decimal", nullable=true)
     */
    private $percentage;

    /**
     * @var \OrderAdjustmentType
     *
     * @ORM\ManyToOne(targetEntity="OrderAdjustmentType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_adjustment_type_id", referencedColumnName="id")
     * })
     */
    private $orderAdjustmentType;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return OrderAdjustment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set percentage
     *
     * @param float $percentage
     * @return OrderAdjustment
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
    
        return $this;
    }

    /**
     * Get percentage
     *
     * @return float 
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Set orderAdjustmentType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\OrderAdjustmentType $orderAdjustmentType
     * @return OrderAdjustment
     */
    public function setOrderAdjustmentType(\Zepluf\Bundle\StoreBundle\Entity\OrderAdjustmentType $orderAdjustmentType = null)
    {
        $this->orderAdjustmentType = $orderAdjustmentType;
    
        return $this;
    }

    /**
     * Get orderAdjustmentType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\OrderAdjustmentType 
     */
    public function getOrderAdjustmentType()
    {
        return $this->orderAdjustmentType;
    }

    /**
     * Set order
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Order $order
     * @return OrderAdjustment
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
}