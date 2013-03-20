<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderTerm
 *
 * @ORM\Table(name="order_term")
 * @ORM\Entity
 */
class OrderTerm
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
     * @ORM\Column(name="value", type="decimal", nullable=true)
     */
    private $value;

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
     * @var \OrderItem
     *
     * @ORM\ManyToOne(targetEntity="OrderItem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_item_id", referencedColumnName="id")
     * })
     */
    private $orderItem;

    /**
     * @var \TermType
     *
     * @ORM\ManyToOne(targetEntity="TermType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="term_type_id", referencedColumnName="id")
     * })
     */
    private $termType;



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
     * Set value
     *
     * @param float $value
     * @return OrderTerm
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return float 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set order
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Order $order
     * @return OrderTerm
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
     * Set orderItem
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\OrderItem $orderItem
     * @return OrderTerm
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

    /**
     * Set termType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\TermType $termType
     * @return OrderTerm
     */
    public function setTermType(\Zepluf\Bundle\StoreBundle\Entity\TermType $termType = null)
    {
        $this->termType = $termType;
    
        return $this;
    }

    /**
     * Get termType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\TermType 
     */
    public function getTermType()
    {
        return $this->termType;
    }
}