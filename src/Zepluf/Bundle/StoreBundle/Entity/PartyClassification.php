<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PartyClassification
 *
 * @ORM\Table(name="party_classification")
 * @ORM\Entity
 */
class PartyClassification
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
     * @ORM\Column(name="through_date", type="datetime", nullable=true)
     */
    private $throughDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="primary_flag", type="boolean", nullable=false)
     */
    private $primaryFlag;

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
     * @var \PartyType
     *
     * @ORM\ManyToOne(targetEntity="PartyType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="party_type_id", referencedColumnName="id")
     * })
     */
    private $partyType;



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
     * @return PartyClassification
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
     * Set throughDate
     *
     * @param \DateTime $throughDate
     * @return PartyClassification
     */
    public function setThroughDate($throughDate)
    {
        $this->throughDate = $throughDate;
    
        return $this;
    }

    /**
     * Get throughDate
     *
     * @return \DateTime 
     */
    public function getThroughDate()
    {
        return $this->throughDate;
    }

    /**
     * Set primaryFlag
     *
     * @param boolean $primaryFlag
     * @return PartyClassification
     */
    public function setPrimaryFlag($primaryFlag)
    {
        $this->primaryFlag = $primaryFlag;
    
        return $this;
    }

    /**
     * Get primaryFlag
     *
     * @return boolean 
     */
    public function getPrimaryFlag()
    {
        return $this->primaryFlag;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return PartyClassification
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
     * @return PartyClassification
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
     * Set partyType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\PartyType $partyType
     * @return PartyClassification
     */
    public function setPartyType(\Zepluf\Bundle\StoreBundle\Entity\PartyType $partyType = null)
    {
        $this->partyType = $partyType;
    
        return $this;
    }

    /**
     * Get partyType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\PartyType 
     */
    public function getPartyType()
    {
        return $this->partyType;
    }
}