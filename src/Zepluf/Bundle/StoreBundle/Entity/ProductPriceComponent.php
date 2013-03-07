<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductPriceComponent
 *
 * @ORM\Table(name="product_price_component")
 * @ORM\Entity
 */
class ProductPriceComponent
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
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

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
     * Set product
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Product $product
     * @return ProductPriceComponent
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
     * Set priceComponent
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\PriceComponent $priceComponent
     * @return ProductPriceComponent
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