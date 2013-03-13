<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductFeature
 *
 * @ORM\Table(name="product_feature")
 * @ORM\Entity
 */
class ProductFeature
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
     * @var integer
     *
     * @ORM\Column(name="order", type="integer", nullable=false)
     */
    private $order;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ProductFeatureValue", inversedBy="productFeature")
     * @ORM\JoinTable(name="product_feature_comprise",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_feature_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="product_feature_value_id", referencedColumnName="id")
     *   }
     * )
     */
    private $productFeatureValue;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="PriceComponent", mappedBy="feature")
     */
    private $priceComponent;

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
     * @var \ProductFeatureCategory
     *
     * @ORM\ManyToOne(targetEntity="ProductFeatureCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_feature_category_id", referencedColumnName="id")
     * })
     */
    private $productFeatureCategory;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productFeatureValue = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return ProductFeature
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
     * @return ProductFeature
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
     * Set order
     *
     * @param integer $order
     * @return ProductFeature
     */
    public function setOrder($order)
    {
        $this->order = $order;
    
        return $this;
    }

    /**
     * Get order
     *
     * @return integer 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Add productFeatureValue
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductFeatureValue $productFeatureValue
     * @return ProductFeature
     */
    public function addProductFeatureValue(\Zepluf\Bundle\StoreBundle\Entity\ProductFeatureValue $productFeatureValue)
    {
        $this->productFeatureValue[] = $productFeatureValue;
    
        return $this;
    }

    /**
     * Remove productFeatureValue
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductFeatureValue $productFeatureValue
     */
    public function removeProductFeatureValue(\Zepluf\Bundle\StoreBundle\Entity\ProductFeatureValue $productFeatureValue)
    {
        $this->productFeatureValue->removeElement($productFeatureValue);
    }

    /**
     * Get productFeatureValue
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductFeatureValue()
    {
        return $this->productFeatureValue;
    }

    /**
     * Add priceComponent
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\PriceComponent $priceComponent
     * @return ProductFeature
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
     * Set unitOfMeasurement
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\UnitOfMeasurement $unitOfMeasurement
     * @return ProductFeature
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
     * Set productFeatureCategory
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductFeatureCategory $productFeatureCategory
     * @return ProductFeature
     */
    public function setProductFeatureCategory(\Zepluf\Bundle\StoreBundle\Entity\ProductFeatureCategory $productFeatureCategory = null)
    {
        $this->productFeatureCategory = $productFeatureCategory;
    
        return $this;
    }

    /**
     * Get productFeatureCategory
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ProductFeatureCategory 
     */
    public function getProductFeatureCategory()
    {
        return $this->productFeatureCategory;
    }
}