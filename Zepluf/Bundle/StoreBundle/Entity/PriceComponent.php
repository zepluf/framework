<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PriceComponent
 *
 * @ORM\Table(name="price_component")
 * @ORM\Entity
 */
class PriceComponent
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="decimal", nullable=false)
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=255, nullable=false)
     */
    private $tag;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ProductFeature", inversedBy="priceComponent")
     * @ORM\JoinTable(name="product_feature_price_component",
     *   joinColumns={
     *     @ORM\JoinColumn(name="price_component_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="feature_id", referencedColumnName="id")
     *   }
     * )
     */
    private $feature;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="priceComponent")
     */
    private $product;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->feature = new \Doctrine\Common\Collections\ArrayCollection();
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set fromDate
     *
     * @param \DateTime $fromDate
     * @return PriceComponent
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
     * @return PriceComponent
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
     * Set name
     *
     * @param string $name
     * @return PriceComponent
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
     * @param float $value
     * @return PriceComponent
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return float 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set tag
     *
     * @param string $tag
     * @return PriceComponent
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    
        return $this;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return PriceComponent
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    
        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Add feature
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductFeature $feature
     * @return PriceComponent
     */
    public function addFeature(\Zepluf\Bundle\StoreBundle\Entity\ProductFeature $feature)
    {
        $this->feature[] = $feature;
    
        return $this;
    }

    /**
     * Remove feature
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductFeature $feature
     */
    public function removeFeature(\Zepluf\Bundle\StoreBundle\Entity\ProductFeature $feature)
    {
        $this->feature->removeElement($feature);
    }

    /**
     * Get feature
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * Add product
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Product $product
     * @return PriceComponent
     */
    public function addProduct(\Zepluf\Bundle\StoreBundle\Entity\Product $product)
    {
        $this->product[] = $product;
    
        return $this;
    }

    /**
     * Remove product
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Product $product
     */
    public function removeProduct(\Zepluf\Bundle\StoreBundle\Entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduct()
    {
        return $this->product;
    }
}