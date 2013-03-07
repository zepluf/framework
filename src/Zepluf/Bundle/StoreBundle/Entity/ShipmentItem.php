<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShipmentItem
 *
 * @ORM\Table(name="shipment_item")
 * @ORM\Entity
 */
class ShipmentItem
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
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="decimal", nullable=true)
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="weight", type="decimal", nullable=true)
     */
    private $weight;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \Shipment
     *
     * @ORM\ManyToOne(targetEntity="Shipment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipment_id", referencedColumnName="id")
     * })
     */
    private $shipment;

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
     * Set quantity
     *
     * @param integer $quantity
     * @return ShipmentItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return ShipmentItem
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set weight
     *
     * @param float $weight
     * @return ShipmentItem
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    
        return $this;
    }

    /**
     * Get weight
     *
     * @return float 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ShipmentItem
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
     * @return ShipmentItem
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
     * Set shipment
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Shipment $shipment
     * @return ShipmentItem
     */
    public function setShipment(\Zepluf\Bundle\StoreBundle\Entity\Shipment $shipment = null)
    {
        $this->shipment = $shipment;
    
        return $this;
    }

    /**
     * Get shipment
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Shipment 
     */
    public function getShipment()
    {
        return $this->shipment;
    }

    /**
     * Set product
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Product $product
     * @return ShipmentItem
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