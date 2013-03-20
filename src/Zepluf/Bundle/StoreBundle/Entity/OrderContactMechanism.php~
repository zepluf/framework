<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderContactMechanism
 *
 * @ORM\Table(name="order_contact_mechanism")
 * @ORM\Entity
 */
class OrderContactMechanism
{
    /**
     * @var \ContactMechanism
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="ContactMechanism")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contact_mechanism_id", referencedColumnName="id")
     * })
     */
    private $contactMechanism;

    /**
     * @var \Order
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Order")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * })
     */
    private $order;

    /**
     * @var \ContactMechanismPurposeType
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="ContactMechanismPurposeType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contact_mechanism_purpose_type_id", referencedColumnName="id")
     * })
     */
    private $contactMechanismPurposeType;



    /**
     * Set contactMechanism
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism $contactMechanism
     * @return OrderContactMechanism
     */
    public function setContactMechanism(\Zepluf\Bundle\StoreBundle\Entity\ContactMechanism $contactMechanism)
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
     * Set order
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Order $order
     * @return OrderContactMechanism
     */
    public function setOrder(\Zepluf\Bundle\StoreBundle\Entity\Order $order)
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
     * Set contactMechanismPurposeType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ContactMechanismPurposeType $contactMechanismPurposeType
     * @return OrderContactMechanism
     */
    public function setContactMechanismPurposeType(\Zepluf\Bundle\StoreBundle\Entity\ContactMechanismPurposeType $contactMechanismPurposeType)
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
}