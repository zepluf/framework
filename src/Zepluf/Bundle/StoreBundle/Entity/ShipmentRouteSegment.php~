<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShipmentRouteSegment
 *
 * @ORM\Table(name="shipment_route_segment")
 * @ORM\Entity
 */
class ShipmentRouteSegment
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
     * @ORM\Column(name="estimated_start_date", type="datetime", nullable=true)
     */
    private $estimatedStartDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="estimated_arrival_date", type="datetime", nullable=true)
     */
    private $estimatedArrivalDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="actual_start_date", type="datetime", nullable=true)
     */
    private $actualStartDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="actual_arrival_date", type="datetime", nullable=true)
     */
    private $actualArrivalDate;

    /**
     * @var string
     *
     * @ORM\Column(name="track_id", type="string", length=255, nullable=true)
     */
    private $trackId;

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
     * @var \Carrier
     *
     * @ORM\ManyToOne(targetEntity="Carrier")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="carrier_id", referencedColumnName="id")
     * })
     */
    private $carrier;

    /**
     * @var \Shipment
     *
     * @ORM\ManyToOne(targetEntity="Shipment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipment_id", referencedColumnName="id")
     * })
     */
    private $shipment;



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
     * Set estimatedStartDate
     *
     * @param \DateTime $estimatedStartDate
     * @return ShipmentRouteSegment
     */
    public function setEstimatedStartDate($estimatedStartDate)
    {
        $this->estimatedStartDate = $estimatedStartDate;
    
        return $this;
    }

    /**
     * Get estimatedStartDate
     *
     * @return \DateTime 
     */
    public function getEstimatedStartDate()
    {
        return $this->estimatedStartDate;
    }

    /**
     * Set estimatedArrivalDate
     *
     * @param \DateTime $estimatedArrivalDate
     * @return ShipmentRouteSegment
     */
    public function setEstimatedArrivalDate($estimatedArrivalDate)
    {
        $this->estimatedArrivalDate = $estimatedArrivalDate;
    
        return $this;
    }

    /**
     * Get estimatedArrivalDate
     *
     * @return \DateTime 
     */
    public function getEstimatedArrivalDate()
    {
        return $this->estimatedArrivalDate;
    }

    /**
     * Set actualStartDate
     *
     * @param \DateTime $actualStartDate
     * @return ShipmentRouteSegment
     */
    public function setActualStartDate($actualStartDate)
    {
        $this->actualStartDate = $actualStartDate;
    
        return $this;
    }

    /**
     * Get actualStartDate
     *
     * @return \DateTime 
     */
    public function getActualStartDate()
    {
        return $this->actualStartDate;
    }

    /**
     * Set actualArrivalDate
     *
     * @param \DateTime $actualArrivalDate
     * @return ShipmentRouteSegment
     */
    public function setActualArrivalDate($actualArrivalDate)
    {
        $this->actualArrivalDate = $actualArrivalDate;
    
        return $this;
    }

    /**
     * Get actualArrivalDate
     *
     * @return \DateTime 
     */
    public function getActualArrivalDate()
    {
        return $this->actualArrivalDate;
    }

    /**
     * Set trackId
     *
     * @param string $trackId
     * @return ShipmentRouteSegment
     */
    public function setTrackId($trackId)
    {
        $this->trackId = $trackId;
    
        return $this;
    }

    /**
     * Get trackId
     *
     * @return string 
     */
    public function getTrackId()
    {
        return $this->trackId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ShipmentRouteSegment
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
     * @return ShipmentRouteSegment
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
     * Set carrier
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Carrier $carrier
     * @return ShipmentRouteSegment
     */
    public function setCarrier(\Zepluf\Bundle\StoreBundle\Entity\Carrier $carrier = null)
    {
        $this->carrier = $carrier;
    
        return $this;
    }

    /**
     * Get carrier
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Carrier 
     */
    public function getCarrier()
    {
        return $this->carrier;
    }

    /**
     * Set shipment
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Shipment $shipment
     * @return ShipmentRouteSegment
     */
    public function setShipment(\Zepluf\Bundle\StoreBundle\Entity\Shipment $shipment = null)
    {
        $this->shipment = $shipment;
    
        return $this;
    }

    /**
     * Get shipment
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Shipment 
     */
    public function getShipment()
    {
        return $this->shipment;
    }
}