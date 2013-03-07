<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity
 */
class Product
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
     * @var boolean
     *
     * @ORM\Column(name="type", type="boolean", nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="introduction_date", type="datetime", nullable=false)
     */
    private $introductionDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sales_discontinuation_date", type="datetime", nullable=true)
     */
    private $salesDiscontinuationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="available_date", type="datetime", nullable=true)
     */
    private $availableDate;

    /**
     * @var \Organization
     *
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="manufacturer_id", referencedColumnName="id")
     * })
     */
    private $manufacturer;

    /**
     * @var \UnitOfMeasurement
     *
     * @ORM\ManyToOne(targetEntity="UnitOfMeasurement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unit_of_measurement_id", referencedColumnName="id")
     * })
     */
    private $unitOfMeasurement;

    /**
     * @var \PriceComponent
     *
     * @ORM\ManyToOne(targetEntity="PriceComponent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="price_component_id", referencedColumnName="id")
     * })
     */
    private $priceComponent;



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
     * Set type
     *
     * @param boolean $type
     * @return Product
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return boolean 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
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
     * @return Product
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
     * Set introductionDate
     *
     * @param \DateTime $introductionDate
     * @return Product
     */
    public function setIntroductionDate($introductionDate)
    {
        $this->introductionDate = $introductionDate;
    
        return $this;
    }

    /**
     * Get introductionDate
     *
     * @return \DateTime 
     */
    public function getIntroductionDate()
    {
        return $this->introductionDate;
    }

    /**
     * Set salesDiscontinuationDate
     *
     * @param \DateTime $salesDiscontinuationDate
     * @return Product
     */
    public function setSalesDiscontinuationDate($salesDiscontinuationDate)
    {
        $this->salesDiscontinuationDate = $salesDiscontinuationDate;
    
        return $this;
    }

    /**
     * Get salesDiscontinuationDate
     *
     * @return \DateTime 
     */
    public function getSalesDiscontinuationDate()
    {
        return $this->salesDiscontinuationDate;
    }

    /**
     * Set availableDate
     *
     * @param \DateTime $availableDate
     * @return Product
     */
    public function setAvailableDate($availableDate)
    {
        $this->availableDate = $availableDate;
    
        return $this;
    }

    /**
     * Get availableDate
     *
     * @return \DateTime 
     */
    public function getAvailableDate()
    {
        return $this->availableDate;
    }

    /**
     * Set manufacturer
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Organization $manufacturer
     * @return Product
     */
    public function setManufacturer(\Zepluf\Bundle\StoreBundle\Entity\Organization $manufacturer = null)
    {
        $this->manufacturer = $manufacturer;
    
        return $this;
    }

    /**
     * Get manufacturer
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Organization 
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Set unitOfMeasurement
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\UnitOfMeasurement $unitOfMeasurement
     * @return Product
     */
    public function setUnitOfMeasurement(\Zepluf\Bundle\StoreBundle\Entity\UnitOfMeasurement $unitOfMeasurement = null)
    {
        $this->unitOfMeasurement = $unitOfMeasurement;
    
        return $this;
    }

    /**
     * Get unitOfMeasurement
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\UnitOfMeasurement 
     */
    public function getUnitOfMeasurement()
    {
        return $this->unitOfMeasurement;
    }

    /**
     * Set priceComponent
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\PriceComponent $priceComponent
     * @return Product
     */
    public function setPriceComponent(\Zepluf\Bundle\StoreBundle\Entity\PriceComponent $priceComponent = null)
    {
        $this->priceComponent = $priceComponent;
    
        return $this;
    }

    /**
     * Get priceComponent
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\PriceComponent 
     */
    public function getPriceComponent()
    {
        return $this->priceComponent;
    }
}