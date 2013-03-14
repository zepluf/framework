<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShipmentMethodType
 *
 * @ORM\Table(name="shipment_method_type")
 * @ORM\Entity
 */
class ShipmentMethodType
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Carrier", inversedBy="shipmentMethodType")
     * @ORM\JoinTable(name="carrier_shipment_method",
     *   joinColumns={
     *     @ORM\JoinColumn(name="shipment_method_type_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="carrier_id", referencedColumnName="id")
     *   }
     * )
     */
    private $carrier;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->carrier = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return ShipmentMethodType
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ShipmentMethodType
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add carrier
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Carrier $carrier
     * @return ShipmentMethodType
     */
    public function addCarrier(\Zepluf\Bundle\StoreBundle\Entity\Carrier $carrier)
    {
        $this->carrier[] = $carrier;
    
        return $this;
    }

    /**
     * Remove carrier
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Carrier $carrier
     */
    public function removeCarrier(\Zepluf\Bundle\StoreBundle\Entity\Carrier $carrier)
    {
        $this->carrier->removeElement($carrier);
    }

    /**
     * Get carrier
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCarrier()
    {
        return $this->carrier;
    }
}