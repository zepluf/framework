<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductFeatureApplicability
 *
 * @ORM\Table(name="product_feature_applicability")
 * @ORM\Entity
 */
class ProductFeatureApplicability
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
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="from_date", type="datetime", nullable=true)
     */
    private $fromDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="through_date", type="datetime", nullable=true)
     */
    private $throughDate;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

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
     * Set type
     *
     * @param integer $type
     * @return ProductFeatureApplicability
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set fromDate
     *
     * @param \DateTime $fromDate
     * @return ProductFeatureApplicability
     */
    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;
    
        return $this;
    }

    /**
     * Get fromDate
     *
     * @return \DateTime 
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * Set throughDate
     *
     * @param \DateTime $throughDate
     * @return ProductFeatureApplicability
     */
    public function setThroughDate($throughDate)
    {
        $this->throughDate = $throughDate;
    
        return $this;
    }

    /**
     * Get throughDate
     *
     * @return \DateTime 
     */
    public function getThroughDate()
    {
        return $this->throughDate;
    }

    /**
     * Set product
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Product $product
     * @return ProductFeatureApplicability
     */
    public function setProduct(\Zepluf\Bundle\StoreBundle\Entity\Product $product = null)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set productFeature
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductFeature $productFeature
     * @return ProductFeatureApplicability
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