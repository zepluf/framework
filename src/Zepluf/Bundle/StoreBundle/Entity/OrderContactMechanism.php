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
     * @var \Order
     *
     * @ORM\ManyToOne(targetEntity="Order")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * })
     */
    private $order;

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
     * @return OrderContactMechanism
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
     * Set order
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Order $order
     * @return OrderContactMechanism
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
     * Set contactMechanismPurposeType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ContactMechanismPurposeType $contactMechanismPurposeType
     * @return OrderContactMechanism
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
}