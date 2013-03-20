<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductFeatureApplication
 *
 * @ORM\Table(name="product_feature_application")
 * @ORM\Entity
 */
class ProductFeatureApplication
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="PriceComponent", mappedBy="productFeatureApplication")
     */
    private $priceComponent;

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
     * @var \ProductFeatureValue
     *
     * @ORM\ManyToOne(targetEntity="ProductFeatureValue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_feature_value_id", referencedColumnName="id")
     * })
     */
    private $productFeatureValue;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->priceComponent = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set type
     *
     * @param integer $type
     * @return ProductFeatureApplication
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
     * @return ProductFeatureApplication
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
     * @return ProductFeatureApplication
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
     * Add priceComponent
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\PriceComponent $priceComponent
     * @return ProductFeatureApplication
     */
    public function addPriceComponent(\Zepluf\Bundle\StoreBundle\Entity\PriceComponent $priceComponent)
    {
        $this->priceComponent[] = $priceComponent;
    
        return $this;
    }

    /**
     * Remove priceComponent
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\PriceComponent $priceComponent
     */
    public function removePriceComponent(\Zepluf\Bundle\StoreBundle\Entity\PriceComponent $priceComponent)
    {
        $this->priceComponent->removeElement($priceComponent);
    }

    /**
     * Get priceComponent
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPriceComponent()
    {
        return $this->priceComponent;
    }

    /**
     * Set product
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Product $product
     * @return ProductFeatureApplication
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
     * Set productFeatureValue
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductFeatureValue $productFeatureValue
     * @return ProductFeatureApplication
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