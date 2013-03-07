<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderItemContactMechanism
 *
 * @ORM\Table(name="order_item_contact_mechanism")
 * @ORM\Entity
 */
class OrderItemContactMechanism
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
     * @var \ContactMechanism
     *
     * @ORM\ManyToOne(targetEntity="ContactMechanism")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contact_mechanism_id", referencedColumnName="id")
     * })
     */
    private $contactMechanism;

    /**
     * @var \ContactMechanismPurposeType
     *
     * @ORM\ManyToOne(targetEntity="ContactMechanismPurposeType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contact_mechanism_purpose_type_id", referencedColumnName="id")
     * })
     */
    private $contactMechanismPurposeType;

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
     * Set contactMechanism
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism $contactMechanism
     * @return OrderItemContactMechanism
     */
    public function setContactMechanism(\Zepluf\Bundle\StoreBundle\Entity\ContactMechanism $contactMechanism = null)
    {
        $this->contactMechanism = $contactMechanism;
    
        return $this;
    }

    /**
     * Get contactMechanism
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism 
     */
    public function getContactMechanism()
    {
        return $this->contactMechanism;
    }

    /**
     * Set contactMechanismPurposeType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ContactMechanismPurposeType $contactMechanismPurposeType
     * @return OrderItemContactMechanism
     */
    public function setContactMechanismPurposeType(\Zepluf\Bundle\StoreBundle\Entity\ContactMechanismPurposeType $contactMechanismPurposeType = null)
    {
        $this->contactMechanismPurposeType = $contactMechanismPurposeType;
    
        return $this;
    }

    /**
     * Get contactMechanismPurposeType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ContactMechanismPurposeType 
     */
    public function getContactMechanismPurposeType()
    {
        return $this->contactMechanismPurposeType;
    }

    /**
     * Set orderItem
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\OrderItem $orderItem
     * @return OrderItemContactMechanism
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