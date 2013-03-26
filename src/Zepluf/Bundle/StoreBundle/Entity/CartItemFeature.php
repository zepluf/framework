<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CartItemFeature
 *
 * @ORM\Table(name="cart_item_feature")
 * @ORM\Entity
 */
class CartItemFeature
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=true)
     */
    private $value;

    /**
     * @var \CartItem
     *
     * @ORM\ManyToOne(targetEntity="CartItem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cart_item_id", referencedColumnName="id")
     * })
     */
    private $cartItem;

    /**
     * @var \ProductFeatureApplication
     *
     * @ORM\ManyToOne(targetEntity="ProductFeatureApplication")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_feature_application_id", referencedColumnName="id")
     * })
     */
    private $productFeatureApplication;



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
     * @return CartItemFeature
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
     * Set value
     *
     * @param string $value
     * @return CartItemFeature
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
     * Set cartItem
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\CartItem $cartItem
     * @return CartItemFeature
     */
    public function setCartItem(\Zepluf\Bundle\StoreBundle\Entity\CartItem $cartItem = null)
    {
        $this->cartItem = $cartItem;
    
        return $this;
    }

    /**
     * Get cartItem
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\CartItem 
     */
    public function getCartItem()
    {
        return $this->cartItem;
    }

    /**
     * Set productFeatureApplication
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductFeatureApplication $productFeatureApplication
     * @return CartItemFeature
     */
    public function setProductFeatureApplication(\Zepluf\Bundle\StoreBundle\Entity\ProductFeatureApplication $productFeatureApplication = null)
    {
        $this->productFeatureApplication = $productFeatureApplication;
    
        return $this;
    }

    /**
     * Get productFeatureApplication
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ProductFeatureApplication 
     */
    public function getProductFeatureApplication()
    {
        return $this->productFeatureApplication;
    }
}