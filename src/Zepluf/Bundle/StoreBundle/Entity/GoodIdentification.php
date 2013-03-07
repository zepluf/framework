<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GoodIdentification
 *
 * @ORM\Table(name="good_identification")
 * @ORM\Entity
 */
class GoodIdentification
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
     * @ORM\Column(name="value", type="string", length=255, nullable=true)
     */
    private $value;

    /**
     * @var \GoodIdentificationType
     *
     * @ORM\ManyToOne(targetEntity="GoodIdentificationType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="good_identification_type_id", referencedColumnName="id")
     * })
     */
    private $goodentificationType;

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
     * Set value
     *
     * @param string $value
     * @return GoodIdentification
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
     * Set goodentificationType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\GoodIdentificationType $goodentificationType
     * @return GoodIdentification
     */
    public function setGoodentificationType(\Zepluf\Bundle\StoreBundle\Entity\GoodIdentificationType $goodentificationType = null)
    {
        $this->goodentificationType = $goodentificationType;
    
        return $this;
    }

    /**
     * Get goodentificationType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\GoodIdentificationType 
     */
    public function getGoodentificationType()
    {
        return $this->goodentificationType;
    }

    /**
     * Set product
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Product $product
     * @return GoodIdentification
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