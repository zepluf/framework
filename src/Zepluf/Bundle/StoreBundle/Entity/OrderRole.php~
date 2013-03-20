<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderRole
 *
 * @ORM\Table(name="order_role")
 * @ORM\Entity
 */
class OrderRole
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
     * @ORM\Column(name="percent_contribution", type="decimal", nullable=true)
     */
    private $percentContribution;

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
     * @var \Party
     *
     * @ORM\ManyToOne(targetEntity="Party")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="party_id", referencedColumnName="id")
     * })
     */
    private $party;

    /**
     * @var \OrderRoleType
     *
     * @ORM\ManyToOne(targetEntity="OrderRoleType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_role_type_id", referencedColumnName="id")
     * })
     */
    private $orderRoleType;



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
     * Set percentContribution
     *
     * @param float $percentContribution
     * @return OrderRole
     */
    public function setPercentContribution($percentContribution)
    {
        $this->percentContribution = $percentContribution;
    
        return $this;
    }

    /**
     * Get percentContribution
     *
     * @return float 
     */
    public function getPercentContribution()
    {
        return $this->percentContribution;
    }

    /**
     * Set order
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Order $order
     * @return OrderRole
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
     * Set party
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Party $party
     * @return OrderRole
     */
    public function setParty(\Zepluf\Bundle\StoreBundle\Entity\Party $party = null)
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

    /**
     * Set orderRoleType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\OrderRoleType $orderRoleType
     * @return OrderRole
     */
    public function setOrderRoleType(\Zepluf\Bundle\StoreBundle\Entity\OrderRoleType $orderRoleType = null)
    {
        $this->orderRoleType = $orderRoleType;
    
        return $this;
    }

    /**
     * Get orderRoleType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\OrderRoleType 
     */
    public function getOrderRoleType()
    {
        return $this->orderRoleType;
    }
}