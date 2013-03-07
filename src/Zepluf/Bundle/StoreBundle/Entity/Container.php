<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Container
 *
 * @ORM\Table(name="container")
 * @ORM\Entity
 */
class Container
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
     * @var \ContainerType
     *
     * @ORM\ManyToOne(targetEntity="ContainerType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="container_type_id", referencedColumnName="id")
     * })
     */
    private $containerType;

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
     * Set containerType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ContainerType $containerType
     * @return Container
     */
    public function setContainerType(\Zepluf\Bundle\StoreBundle\Entity\ContainerType $containerType = null)
    {
        $this->containerType = $containerType;
    
        return $this;
    }

    /**
     * Get containerType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ContainerType 
     */
    public function getContainerType()
    {
        return $this->containerType;
    }

    /**
     * Set facility
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Facility $facility
     * @return Container
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