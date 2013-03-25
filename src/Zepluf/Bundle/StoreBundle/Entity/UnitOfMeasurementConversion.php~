<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UnitOfMeasurementConversion
 *
 * @ORM\Table(name="unit_of_measurement_conversion")
 * @ORM\Entity
 */
class UnitOfMeasurementConversion
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
     * @var float
     *
     * @ORM\Column(name="factor", type="decimal", nullable=false)
     */
    private $factor;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \UnitOfMeasurement
     *
     * @ORM\ManyToOne(targetEntity="UnitOfMeasurement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="from_unit_of_measurement_id", referencedColumnName="id")
     * })
     */
    private $fromUnitOfMeasurement;

    /**
     * @var \UnitOfMeasurement
     *
     * @ORM\ManyToOne(targetEntity="UnitOfMeasurement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="to_unit_of_measurement_id", referencedColumnName="id")
     * })
     */
    private $toUnitOfMeasurement;



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
     * Set factor
     *
     * @param float $factor
     * @return UnitOfMeasurementConversion
     */
    public function setFactor($factor)
    {
        $this->factor = $factor;
    
        return $this;
    }

    /**
     * Get factor
     *
     * @return float 
     */
    public function getFactor()
    {
        return $this->factor;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return UnitOfMeasurementConversion
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
     * Set fromUnitOfMeasurement
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\UnitOfMeasurement $fromUnitOfMeasurement
     * @return UnitOfMeasurementConversion
     */
    public function setFromUnitOfMeasurement(\Zepluf\Bundle\StoreBundle\Entity\UnitOfMeasurement $fromUnitOfMeasurement = null)
    {
        $this->fromUnitOfMeasurement = $fromUnitOfMeasurement;
    
        return $this;
    }

    /**
     * Get fromUnitOfMeasurement
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\UnitOfMeasurement 
     */
    public function getFromUnitOfMeasurement()
    {
        return $this->fromUnitOfMeasurement;
    }

    /**
     * Set toUnitOfMeasurement
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\UnitOfMeasurement $toUnitOfMeasurement
     * @return UnitOfMeasurementConversion
     */
    public function setToUnitOfMeasurement(\Zepluf\Bundle\StoreBundle\Entity\UnitOfMeasurement $toUnitOfMeasurement = null)
    {
        $this->toUnitOfMeasurement = $toUnitOfMeasurement;
    
        return $this;
    }

    /**
     * Get toUnitOfMeasurement
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\UnitOfMeasurement 
     */
    public function getToUnitOfMeasurement()
    {
        return $this->toUnitOfMeasurement;
    }
}