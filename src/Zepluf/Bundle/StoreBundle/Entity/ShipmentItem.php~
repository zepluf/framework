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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \Shipment
     *
     * @ORM\ManyToOne(targetEntity="Shipment", inversedBy="shipmentItems")
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
     * @var ShipmentItemFeature|array
     *
     * @ORM\OneToMany(targetEntity="ShipmentItemFeature", mappedBy="shipmentItem", cascade={"persist", "remove"})
     */
    private $features;



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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->features = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add features
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ShipmentItemFeature $features
     * @return ShipmentItem
     */
    public function addFeature(\Zepluf\Bundle\StoreBundle\Entity\ShipmentItemFeature $features)
    {
        $this->features[] = $features;
    
        return $this;
    }

    /**
     * Remove features
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ShipmentItemFeature $features
     */
    public function removeFeature(\Zepluf\Bundle\StoreBundle\Entity\ShipmentItemFeature $features)
    {
        $this->features->removeElement($features);
    }

    /**
     * Get features
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFeatures()
    {
        return $this->features;
    }
}