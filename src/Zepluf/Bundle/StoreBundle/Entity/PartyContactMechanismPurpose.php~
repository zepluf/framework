<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PartyContactMechanismPurpose
 *
 * @ORM\Table(name="party_contact_mechanism_purpose")
 * @ORM\Entity
 */
class PartyContactMechanismPurpose
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
     * @ORM\Column(name="from_date", type="datetime", nullable=true)
     */
    private $fromDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="thru_date", type="datetime", nullable=true)
     */
    private $thruDate;

    /**
     * @var \ContactMechanism
     *
     * @ORM\ManyToOne(targetEntity="ContactMechanism")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="party_contact_mechanism_id", referencedColumnName="id")
     * })
     */
    private $partyContactMechanism;

    /**
     * @var \ContactMechanismType
     *
     * @ORM\ManyToOne(targetEntity="ContactMechanismType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contact_mechanism_type_id", referencedColumnName="id")
     * })
     */
    private $contactMechanismType;



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
     * Set fromDate
     *
     * @param \DateTime $fromDate
     * @return PartyContactMechanismPurpose
     */
    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;
    
        return $this;
    }

    /**
     * Get fromDate
     *
     * @return \DateTime 
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * Set thruDate
     *
     * @param \DateTime $thruDate
     * @return PartyContactMechanismPurpose
     */
    public function setThruDate($thruDate)
    {
        $this->thruDate = $thruDate;
    
        return $this;
    }

    /**
     * Get thruDate
     *
     * @return \DateTime 
     */
    public function getThruDate()
    {
        return $this->thruDate;
    }

    /**
     * Set partyContactMechanism
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism $partyContactMechanism
     * @return PartyContactMechanismPurpose
     */
    public function setPartyContactMechanism(\Zepluf\Bundle\StoreBundle\Entity\ContactMechanism $partyContactMechanism = null)
    {
        $this->partyContactMechanism = $partyContactMechanism;
    
        return $this;
    }

    /**
     * Get partyContactMechanism
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism 
     */
    public function getPartyContactMechanism()
    {
        return $this->partyContactMechanism;
    }

    /**
     * Set contactMechanismType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ContactMechanismType $contactMechanismType
     * @return PartyContactMechanismPurpose
     */
    public function setContactMechanismType(\Zepluf\Bundle\StoreBundle\Entity\ContactMechanismType $contactMechanismType = null)
    {
        $this->contactMechanismType = $contactMechanismType;
    
        return $this;
    }

    /**
     * Get contactMechanismType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ContactMechanismType 
     */
    public function getContactMechanismType()
    {
        return $this->contactMechanismType;
    }
}