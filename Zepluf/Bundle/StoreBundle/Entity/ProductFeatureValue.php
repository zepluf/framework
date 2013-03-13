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
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=false)
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ProductFeature", mappedBy="productFeatureValue")
     */
    private $productFeature;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productFeature = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set value
     *
     * @param string $value
     * @return ProductFeatureValue
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
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
     * Add productFeature
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductFeature $productFeature
     * @return ProductFeatureValue
     */
    public function addProductFeature(\Zepluf\Bundle\StoreBundle\Entity\ProductFeature $productFeature)
    {
        $this->productFeature[] = $productFeature;
    
        return $this;
    }

    /**
     * Remove productFeature
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductFeature $productFeature
     */
    public function removeProductFeature(\Zepluf\Bundle\StoreBundle\Entity\ProductFeature $productFeature)
    {
        $this->productFeature->removeElement($productFeature);
    }

    /**
     * Get productFeature
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductFeature()
    {
        return $this->productFeature;
    }
}