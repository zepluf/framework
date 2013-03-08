<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductFeaturePriceComponent
 *
 * @ORM\Table(name="product_feature_price_component")
 * @ORM\Entity
 */
class ProductFeaturePriceComponent
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
     *   @ORM\JoinColumn(name="feature_id", referencedColumnName="id")
     * })
     */
    private $feature;

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
     * Set feature
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductFeature $feature
     * @return ProductFeaturePriceComponent
     */
    public function setFeature(\Zepluf\Bundle\StoreBundle\Entity\ProductFeature $feature = null)
    {
        $this->feature = $feature;
    
        return $this;
    }

    /**
     * Get feature
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ProductFeature 
     */
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * Set priceComponent
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\PriceComponent $priceComponent
     * @return ProductFeaturePriceComponent
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