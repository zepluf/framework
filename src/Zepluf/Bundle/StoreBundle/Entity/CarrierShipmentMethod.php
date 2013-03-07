<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CarrierShipmentMethod
 *
 * @ORM\Table(name="carrier_shipment_method")
 * @ORM\Entity
 */
class CarrierShipmentMethod
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
     * @var \Carrier
     *
     * @ORM\ManyToOne(targetEntity="Carrier")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="carrier_id", referencedColumnName="id")
     * })
     */
    private $carrier;

    /**
     * @var \ShipmentMethodType
     *
     * @ORM\ManyToOne(targetEntity="ShipmentMethodType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipment_method_type_id", referencedColumnName="id")
     * })
     */
    private $shipmentMethodType;



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
     * Set carrier
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Carrier $carrier
     * @return CarrierShipmentMethod
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
     * Set shipmentMethodType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ShipmentMethodType $shipmentMethodType
     * @return CarrierShipmentMethod
     */
    public function setShipmentMethodType(\Zepluf\Bundle\StoreBundle\Entity\ShipmentMethodType $shipmentMethodType = null)
    {
        $this->shipmentMethodType = $shipmentMethodType;
    
        return $this;
    }

    /**
     * Get shipmentMethodType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ShipmentMethodType 
     */
    public function getShipmentMethodType()
    {
        return $this->shipmentMethodType;
    }
}