<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShipmentItemFeature
 *
 * @ORM\Table(name="shipment_item_feature")
 * @ORM\Entity
 */
class ShipmentItemFeature
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
     * @var \ShipmentItem
     *
     * @ORM\ManyToOne(targetEntity="ShipmentItem", inversedBy="features")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipment_item_id", referencedColumnName="id")
     * })
     */
    private $shipmentItem;

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
     * @return ShipmentItemFeature
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
     * @return ShipmentItemFeature
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
     * Set shipmentItem
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ShipmentItem $shipmentItem
     * @return ShipmentItemFeature
     */
    public function setShipmentItem(\Zepluf\Bundle\StoreBundle\Entity\ShipmentItem $shipmentItem = null)
    {
        $this->shipmentItem = $shipmentItem;
    
        return $this;
    }

    /**
     * Get shipmentItem
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ShipmentItem 
     */
    public function getShipmentItem()
    {
        return $this->shipmentItem;
    }

    /**
     * Set productFeatureApplication
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductFeatureApplication $productFeatureApplication
     * @return ShipmentItemFeature
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