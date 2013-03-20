<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PartyType
 *
 * @ORM\Table(name="party_type")
 * @ORM\Entity
 */
class PartyType
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
     * Set name
     *
     * @param string $name
     * @return PartyType
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
     * @return PartyType
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
     * Set priceComponent
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\PriceComponent $priceComponent
     * @return PartyType
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