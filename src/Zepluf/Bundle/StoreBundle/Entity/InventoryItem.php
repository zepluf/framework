<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryItem
 *
 * @ORM\Table(name="inventory_item")
 * @ORM\Entity(repositoryClass="Zepluf\Bundle\StoreBundle\Entity\InventoryItemRepository")
 */
class InventoryItem
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
     * @ORM\Column(name="feature_value_ids", type="text", nullable=true)
     */
    private $featureValueIds;

    /**
     * @var string
     *
     * @ORM\Column(name="serial", type="string", length=255, nullable=true)
     */
    private $serial;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity_onhand", type="integer", nullable=false)
     */
    private $quantityOnhand;

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
     * @var \InventoryItemStatusType
     *
     * @ORM\ManyToOne(targetEntity="InventoryItemStatusType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inventory_item_status_type_id", referencedColumnName="id")
     * })
     */
    private $inventoryItemStatusType;

    /**
     * @var \Location
     *
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     * })
     */
    private $location;



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
     * Set featureValueIds
     *
     * @param string $featureValueIds
     * @return InventoryItem
     */
    public function setFeatureValueIds($featureValueIds)
    {
        $this->featureValueIds = $featureValueIds;
    
        return $this;
    }

    /**
     * Get featureValueIds
     *
     * @return string 
     */
    public function getFeatureValueIds()
    {
        return $this->featureValueIds;
    }

    /**
     * Set serial
     *
     * @param string $serial
     * @return InventoryItem
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;
    
        return $this;
    }

    /**
     * Get serial
     *
     * @return string 
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * Set quantityOnhand
     *
     * @param integer $quantityOnhand
     * @return InventoryItem
     */
    public function setQuantityOnhand($quantityOnhand)
    {
        $this->quantityOnhand = $quantityOnhand;
    
        return $this;
    }

    /**
     * Get quantityOnhand
     *
     * @return integer 
     */
    public function getQuantityOnhand()
    {
        return $this->quantityOnhand;
    }

    /**
     * Set product
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Product $product
     * @return InventoryItem
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
     * Set inventoryItemStatusType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\InventoryItemStatusType $inventoryItemStatusType
     * @return InventoryItem
     */
    public function setInventoryItemStatusType(\Zepluf\Bundle\StoreBundle\Entity\InventoryItemStatusType $inventoryItemStatusType = null)
    {
        $this->inventoryItemStatusType = $inventoryItemStatusType;
    
        return $this;
    }

    /**
     * Get inventoryItemStatusType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\InventoryItemStatusType 
     */
    public function getInventoryItemStatusType()
    {
        return $this->inventoryItemStatusType;
    }

    /**
     * Set location
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Location $location
     * @return InventoryItem
     */
    public function setLocation(\Zepluf\Bundle\StoreBundle\Entity\Location $location = null)
    {
        $this->location = $location;
    
        return $this;
    }

    /**
     * Get location
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }
}