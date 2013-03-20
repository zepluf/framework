<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PartyContactMechanism
 *
 * @ORM\Table(name="party_contact_mechanism")
 * @ORM\Entity
 */
class PartyContactMechanism
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
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

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
     * @var \ContactMechanism
     *
     * @ORM\ManyToOne(targetEntity="ContactMechanism")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contact_mechanism_id", referencedColumnName="id")
     * })
     */
    private $contactMechanism;

    /**
     * @var \PartyRoleType
     *
     * @ORM\ManyToOne(targetEntity="PartyRoleType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="party_role_type_id", referencedColumnName="id")
     * })
     */
    private $partyRoleType;



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
     * @return PartyContactMechanism
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
     * @return PartyContactMechanism
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
     * Set comment
     *
     * @param string $comment
     * @return PartyContactMechanism
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
     * Set party
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Party $party
     * @return PartyContactMechanism
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
     * Set contactMechanism
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism $contactMechanism
     * @return PartyContactMechanism
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
     * Set partyRoleType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\PartyRoleType $partyRoleType
     * @return PartyContactMechanism
     */
    public function setPartyRoleType(\Zepluf\Bundle\StoreBundle\Entity\PartyRoleType $partyRoleType = null)
    {
        $this->partyRoleType = $partyRoleType;
    
        return $this;
    }

    /**
     * Get partyRoleType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\PartyRoleType 
     */
    public function getPartyRoleType()
    {
        return $this->partyRoleType;
    }
}