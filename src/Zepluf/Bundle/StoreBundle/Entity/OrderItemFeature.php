<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderItemFeature
 *
 * @ORM\Table(name="order_item_feature")
 * @ORM\Entity
 */
class OrderItemFeature
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
     * @var \OrderItem
     *
     * @ORM\ManyToOne(targetEntity="OrderItem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_item_id", referencedColumnName="id")
     * })
     */
    private $orderItem;

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
     * @return OrderItemFeature
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
     * @return OrderItemFeature
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
     * Set orderItem
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\OrderItem $orderItem
     * @return OrderItemFeature
     */
    public function setOrderItem(\Zepluf\Bundle\StoreBundle\Entity\OrderItem $orderItem = null)
    {
        $this->orderItem = $orderItem;
    
        return $this;
    }

    /**
     * Get orderItem
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\OrderItem 
     */
    public function getOrderItem()
    {
        return $this->orderItem;
    }

    /**
     * Set productFeatureApplication
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductFeatureApplication $productFeatureApplication
     * @return OrderItemFeature
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