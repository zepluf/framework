<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductFeatureComprise
 *
 * @ORM\Table(name="product_feature_comprise")
 * @ORM\Entity
 */
class ProductFeatureComprise
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
     * @var \ProductFeature
     *
     * @ORM\ManyToOne(targetEntity="ProductFeature")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_feature_id", referencedColumnName="id")
     * })
     */
    private $productFeature;

    /**
     * @var \ProductFeatureValue
     *
     * @ORM\ManyToOne(targetEntity="ProductFeatureValue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_feature_value_id", referencedColumnName="id")
     * })
     */
    private $productFeatureValue;



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
     * Set productFeature
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductFeature $productFeature
     * @return ProductFeatureComprise
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

    /**
     * Set productFeatureValue
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductFeatureValue $productFeatureValue
     * @return ProductFeatureComprise
     */
    public function setProductFeatureValue(\Zepluf\Bundle\StoreBundle\Entity\ProductFeatureValue $productFeatureValue = null)
    {
        $this->productFeatureValue = $productFeatureValue;
    
        return $this;
    }

    /**
     * Get productFeatureValue
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ProductFeatureValue 
     */
    public function getProductFeatureValue()
    {
        return $this->productFeatureValue;
    }
}