<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderItemRole
 *
 * @ORM\Table(name="order_item_role")
 * @ORM\Entity
 */
class OrderItemRole
{
    /**
     * @var \OrderItem
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="OrderItem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_item_id", referencedColumnName="id")
     * })
     */
    private $orderItem;

    /**
     * @var \OrderItemRoleType
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="OrderItemRoleType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_item_role_type_id", referencedColumnName="id")
     * })
     */
    private $orderItemRoleType;

    /**
     * @var \Party
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Party")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="party_id", referencedColumnName="id")
     * })
     */
    private $party;



    /**
     * Set orderItem
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\OrderItem $orderItem
     * @return OrderItemRole
     */
    public function setOrderItem(\Zepluf\Bundle\StoreBundle\Entity\OrderItem $orderItem)
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
     * Set orderItemRoleType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\OrderItemRoleType $orderItemRoleType
     * @return OrderItemRole
     */
    public function setOrderItemRoleType(\Zepluf\Bundle\StoreBundle\Entity\OrderItemRoleType $orderItemRoleType)
    {
        $this->orderItemRoleType = $orderItemRoleType;
    
        return $this;
    }

    /**
     * Get orderItemRoleType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\OrderItemRoleType 
     */
    public function getOrderItemRoleType()
    {
        return $this->orderItemRoleType;
    }

    /**
     * Set party
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Party $party
     * @return OrderItemRole
     */
    public function setParty(\Zepluf\Bundle\StoreBundle\Entity\Party $party)
    {
        $this->party = $party;
    
        return $this;
    }

    /**
     * Get party
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Party 
     */
    public function getParty()
    {
        return $this->party;
    }
}