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
     * @var integer
     *
     * @ORM\Column(name="sort", type="integer", options={"unsigned"=true}, nullable=false)
     */
    private $sort;

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
     * @var \UnitOfMeasurement
     *
     * @ORM\ManyToOne(targetEntity="UnitOfMeasurement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unit_of_measurement_id", referencedColumnName="id")
     * })
     */
    private $unitOfMeasurement;



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
     * Set sort
     *
     * @param integer $sort
     * @return ProductFeature
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    
        return $this;
    }

    /**
     * Get sort
     *
     * @return integer 
     */
    public function getSort()
    {
        return $this->sort;
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
}