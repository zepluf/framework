<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductTerm
 *
 * @ORM\Table(name="product_term")
 * @ORM\Entity
 */
class ProductTerm
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
     * @var \TermType
     *
     * @ORM\ManyToOne(targetEntity="TermType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="term_type_id", referencedColumnName="id")
     * })
     */
    private $termType;



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
     * @return ProductTerm
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
     * Set termType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\TermType $termType
     * @return ProductTerm
     */
    public function setTermType(\Zepluf\Bundle\StoreBundle\Entity\TermType $termType = null)
    {
        $this->termType = $termType;
    
        return $this;
    }

    /**
     * Get termType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\TermType 
     */
    public function getTermType()
    {
        return $this->termType;
    }
}