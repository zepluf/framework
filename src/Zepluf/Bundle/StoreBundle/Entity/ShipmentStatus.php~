<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShipmentStatus
 *
 * @ORM\Table(name="shipment_status")
 * @ORM\Entity
 */
class ShipmentStatus
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
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

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
     * @var \ShipmentStatusType
     *
     * @ORM\ManyToOne(targetEntity="ShipmentStatusType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipment_status_type_id", referencedColumnName="id")
     * })
     */
    private $shipmentStatusType;



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
     * Set date
     *
     * @param \DateTime $date
     * @return ShipmentStatus
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set shipment
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Shipment $shipment
     * @return ShipmentStatus
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

    /**
     * Set shipmentStatusType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ShipmentStatusType $shipmentStatusType
     * @return ShipmentStatus
     */
    public function setShipmentStatusType(\Zepluf\Bundle\StoreBundle\Entity\ShipmentStatusType $shipmentStatusType = null)
    {
        $this->shipmentStatusType = $shipmentStatusType;
    
        return $this;
    }

    /**
     * Get shipmentStatusType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ShipmentStatusType 
     */
    public function getShipmentStatusType()
    {
        return $this->shipmentStatusType;
    }
}