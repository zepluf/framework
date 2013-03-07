<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductAssociation
 *
 * @ORM\Table(name="product_association")
 * @ORM\Entity
 */
class ProductAssociation
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
     * @ORM\Column(name="from_date", type="datetime", nullable=false)
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
     * @ORM\Column(name="reason", type="string", length=255, nullable=true)
     */
    private $reason;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="from_product_id", referencedColumnName="id")
     * })
     */
    private $fromProduct;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="to_product_id", referencedColumnName="id")
     * })
     */
    private $toProduct;

    /**
     * @var \ProductAssociationType
     *
     * @ORM\ManyToOne(targetEntity="ProductAssociationType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_association_type_id", referencedColumnName="id")
     * })
     */
    private $productAssociationType;



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
     * @return ProductAssociation
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
     * @return ProductAssociation
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
     * Set reason
     *
     * @param string $reason
     * @return ProductAssociation
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    
        return $this;
    }

    /**
     * Get reason
     *
     * @return string 
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set fromProduct
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Product $fromProduct
     * @return ProductAssociation
     */
    public function setFromProduct(\Zepluf\Bundle\StoreBundle\Entity\Product $fromProduct = null)
    {
        $this->fromProduct = $fromProduct;
    
        return $this;
    }

    /**
     * Get fromProduct
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Product 
     */
    public function getFromProduct()
    {
        return $this->fromProduct;
    }

    /**
     * Set toProduct
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Product $toProduct
     * @return ProductAssociation
     */
    public function setToProduct(\Zepluf\Bundle\StoreBundle\Entity\Product $toProduct = null)
    {
        $this->toProduct = $toProduct;
    
        return $this;
    }

    /**
     * Get toProduct
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Product 
     */
    public function getToProduct()
    {
        return $this->toProduct;
    }

    /**
     * Set productAssociationType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductAssociationType $productAssociationType
     * @return ProductAssociation
     */
    public function setProductAssociationType(\Zepluf\Bundle\StoreBundle\Entity\ProductAssociationType $productAssociationType = null)
    {
        $this->productAssociationType = $productAssociationType;
    
        return $this;
    }

    /**
     * Get productAssociationType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ProductAssociationType 
     */
    public function getProductAssociationType()
    {
        return $this->productAssociationType;
    }
}