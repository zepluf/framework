<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Shipment
 *
 * @ORM\Table(name="shipment")
 * @ORM\Entity
 */
class Shipment
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
     * @var string
     *
     * @ORM\Column(name="increment_id", type="string", length=45, nullable=false)
     */
    private $incrementId;

    /**
     * @var ShipmentItem|array
     *
     * @ORM\OneToMany(targetEntity="ShipmentItem", mappedBy="shipment")
     */
    private $shipmentItems;

    /**
     * @var float
     *
     * @ORM\Column(name="ship_cost", type="decimal", nullable=true)
     */
    private $shipCost;

    /**
     * @var float
     *
     * @ORM\Column(name="total_weight", type="decimal", nullable=true)
     */
    private $totalWeight;

    /**
     * @var string
     *
     * @ORM\Column(name="handling_instructions", type="string", length=255, nullable=true)
     */
    private $handlingInstructions;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \ShipmentType
     *
     * @ORM\ManyToOne(targetEntity="ShipmentType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipment_type_id", referencedColumnName="id")
     * })
     */
    private $shipmentType;

    /**
     * @var \Party
     *
     * @ORM\ManyToOne(targetEntity="Party")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipped_from_party_id", referencedColumnName="id")
     * })
     */
    private $shippedFromParty;

    /**
     * @var \Party
     *
     * @ORM\ManyToOne(targetEntity="Party")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipped_to_party_id", referencedColumnName="id")
     * })
     */
    private $shippedToParty;

    /**
     * @var \ContactMechanism
     *
     * @ORM\ManyToOne(targetEntity="ContactMechanism")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipped_from_contact_mechanism_id", referencedColumnName="id")
     * })
     */
    private $shippedFromContactMechanism;

    /**
     * @var \ContactMechanism
     *
     * @ORM\ManyToOne(targetEntity="ContactMechanism")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipped_to_contact_mechanism_id", referencedColumnName="id")
     * })
     */
    private $shippedToContactMechanism;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->shipmentItems = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set incrementId
     *
     * @param string $incrementId
     * @return Shipment
     */
    public function setIncrementId($incrementId)
    {
        $this->incrementId = $incrementId;
    
        return $this;
    }

    /**
     * Get incrementId
     *
     * @return string 
     */
    public function getIncrementId()
    {
        return $this->incrementId;
    }

    /**
     * Set shipCost
     *
     * @param float $shipCost
     * @return Shipment
     */
    public function setShipCost($shipCost)
    {
        $this->shipCost = $shipCost;
    
        return $this;
    }

    /**
     * Get shipCost
     *
     * @return float 
     */
    public function getShipCost()
    {
        return $this->shipCost;
    }

    /**
     * Set totalWeight
     *
     * @param float $totalWeight
     * @return Shipment
     */
    public function setTotalWeight($totalWeight)
    {
        $this->totalWeight = $totalWeight;
    
        return $this;
    }

    /**
     * Get totalWeight
     *
     * @return float 
     */
    public function getTotalWeight()
    {
        return $this->totalWeight;
    }

    /**
     * Set handlingInstructions
     *
     * @param string $handlingInstructions
     * @return Shipment
     */
    public function setHandlingInstructions($handlingInstructions)
    {
        $this->handlingInstructions = $handlingInstructions;
    
        return $this;
    }

    /**
     * Get handlingInstructions
     *
     * @return string 
     */
    public function getHandlingInstructions()
    {
        return $this->handlingInstructions;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Shipment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Shipment
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add shipmentItems
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ShipmentItem $shipmentItems
     * @return Shipment
     */
    public function addShipmentItem(\Zepluf\Bundle\StoreBundle\Entity\ShipmentItem $shipmentItems)
    {
        $this->shipmentItems[] = $shipmentItems;
    
        return $this;
    }

    /**
     * Remove shipmentItems
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ShipmentItem $shipmentItems
     */
    public function removeShipmentItem(\Zepluf\Bundle\StoreBundle\Entity\ShipmentItem $shipmentItems)
    {
        $this->shipmentItems->removeElement($shipmentItems);
    }

    /**
     * Get shipmentItems
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getShipmentItems()
    {
        return $this->shipmentItems;
    }

    /**
     * Set shipmentType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ShipmentType $shipmentType
     * @return Shipment
     */
    public function setShipmentType(\Zepluf\Bundle\StoreBundle\Entity\ShipmentType $shipmentType = null)
    {
        $this->shipmentType = $shipmentType;
    
        return $this;
    }

    /**
     * Get shipmentType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ShipmentType 
     */
    public function getShipmentType()
    {
        return $this->shipmentType;
    }

    /**
     * Set shippedFromParty
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Party $shippedFromParty
     * @return Shipment
     */
    public function setShippedFromParty(\Zepluf\Bundle\StoreBundle\Entity\Party $shippedFromParty = null)
    {
        $this->shippedFromParty = $shippedFromParty;
    
        return $this;
    }

    /**
     * Get shippedFromParty
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Party 
     */
    public function getShippedFromParty()
    {
        return $this->shippedFromParty;
    }

    /**
     * Set shippedToParty
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Party $shippedToParty
     * @return Shipment
     */
    public function setShippedToParty(\Zepluf\Bundle\StoreBundle\Entity\Party $shippedToParty = null)
    {
        $this->shippedToParty = $shippedToParty;
    
        return $this;
    }

    /**
     * Get shippedToParty
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Party 
     */
    public function getShippedToParty()
    {
        return $this->shippedToParty;
    }

    /**
     * Set shippedFromContactMechanism
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism $shippedFromContactMechanism
     * @return Shipment
     */
    public function setShippedFromContactMechanism(\Zepluf\Bundle\StoreBundle\Entity\ContactMechanism $shippedFromContactMechanism = null)
    {
        $this->shippedFromContactMechanism = $shippedFromContactMechanism;
    
        return $this;
    }

    /**
     * Get shippedFromContactMechanism
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism 
     */
    public function getShippedFromContactMechanism()
    {
        return $this->shippedFromContactMechanism;
    }

    /**
     * Set shippedToContactMechanism
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism $shippedToContactMechanism
     * @return Shipment
     */
    public function setShippedToContactMechanism(\Zepluf\Bundle\StoreBundle\Entity\ContactMechanism $shippedToContactMechanism = null)
    {
        $this->shippedToContactMechanism = $shippedToContactMechanism;
    
        return $this;
    }

    /**
     * Get shippedToContactMechanism
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism 
     */
    public function getShippedToContactMechanism()
    {
        return $this->shippedToContactMechanism;
    }
}