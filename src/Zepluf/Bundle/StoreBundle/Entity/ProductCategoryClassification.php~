<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductCategoryClassification
 *
 * @ORM\Table(name="product_category_classification")
 * @ORM\Entity
 */
class ProductCategoryClassification
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
     * @var boolean
     *
     * @ORM\Column(name="primary_flag", type="boolean", nullable=true)
     */
    private $primaryFlag;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @var \ProductCategory
     *
     * @ORM\ManyToOne(targetEntity="ProductCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_category_id", referencedColumnName="id")
     * })
     */
    private $productCategory;

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
     * @return ProductCategoryClassification
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
     * @return ProductCategoryClassification
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
     * Set primaryFlag
     *
     * @param boolean $primaryFlag
     * @return ProductCategoryClassification
     */
    public function setPrimaryFlag($primaryFlag)
    {
        $this->primaryFlag = $primaryFlag;
    
        return $this;
    }

    /**
     * Get primaryFlag
     *
     * @return boolean 
     */
    public function getPrimaryFlag()
    {
        return $this->primaryFlag;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return ProductCategoryClassification
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
     * Set productCategory
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductCategory $productCategory
     * @return ProductCategoryClassification
     */
    public function setProductCategory(\Zepluf\Bundle\StoreBundle\Entity\ProductCategory $productCategory = null)
    {
        $this->productCategory = $productCategory;
    
        return $this;
    }

    /**
     * Get productCategory
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ProductCategory 
     */
    public function getProductCategory()
    {
        return $this->productCategory;
    }

    /**
     * Set product
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Product $product
     * @return ProductCategoryClassification
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
}