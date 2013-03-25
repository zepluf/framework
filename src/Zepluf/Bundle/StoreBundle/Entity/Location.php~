<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="location")
 * @ORM\Entity
 */
class Location
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
     * @var \Lot
     *
     * @ORM\ManyToOne(targetEntity="Lot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lot_id", referencedColumnName="id")
     * })
     */
    private $lot;

    /**
     * @var \Container
     *
     * @ORM\ManyToOne(targetEntity="Container")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="container_id", referencedColumnName="id")
     * })
     */
    private $container;

    /**
     * @var \Facility
     *
     * @ORM\ManyToOne(targetEntity="Facility")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="facility_id", referencedColumnName="id")
     * })
     */
    private $facility;



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
     * Set lot
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Lot $lot
     * @return Location
     */
    public function setLot(\Zepluf\Bundle\StoreBundle\Entity\Lot $lot = null)
    {
        $this->lot = $lot;
    
        return $this;
    }

    /**
     * Get lot
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Lot 
     */
    public function getLot()
    {
        return $this->lot;
    }

    /**
     * Set container
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Container $container
     * @return Location
     */
    public function setContainer(\Zepluf\Bundle\StoreBundle\Entity\Container $container = null)
    {
        $this->container = $container;
    
        return $this;
    }

    /**
     * Get container
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Container 
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Set facility
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Facility $facility
     * @return Location
     */
    public function setFacility(\Zepluf\Bundle\StoreBundle\Entity\Facility $facility = null)
    {
        $this->facility = $facility;
    
        return $this;
    }

    /**
     * Get facility
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Facility 
     */
    public function getFacility()
    {
        return $this->facility;
    }
}