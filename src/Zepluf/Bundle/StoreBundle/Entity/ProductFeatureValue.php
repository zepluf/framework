<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductFeatureValue
 *
 * @ORM\Table(name="product_feature_value")
 * @ORM\Entity
 */
class ProductFeatureValue
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true}, nullable=false)
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
     * @var \ProductFeature
     *
     * @ORM\ManyToOne(targetEntity="ProductFeature")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_feature_id", referencedColumnName="id")
     * })
     */
    private $productFeature;



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
     * @return ProductFeatureValue
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
     * @return ProductFeatureValue
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
     * Set productFeature
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductFeature $productFeature
     * @return ProductFeatureValue
     */
    public function setProductFeature(\Zepluf\Bundle\StoreBundle\Entity\ProductFeature $productFeature = null)
    {
        $this->productFeature = $productFeature;
    
        return $this;
    }

    /**
     * Get productFeature
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ProductFeature 
     */
    public function getProductFeature()
    {
        return $this->productFeature;
    }
}