<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryItem
 *
 * @ORM\Table(name="inventory_item")
 * @ORM\Entity
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
     * @ORM\Column(name="feature_value_ids", type="string", length=255, nullable=true)
     */
    private $featureValueIds;

    /**
     * @var string
     *
     * @ORM\Column(name="key", type="string", length=255, nullable=true)
     */
    private $key;

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
     * @var \Container
     *
     * @ORM\ManyToOne(targetEntity="Container")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="container_id", referencedColumnName="id")
     * })
     */
    private $container;

    /**
     * @var \Lot
     *
     * @ORM\ManyToOne(targetEntity="Lot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lot_id", referencedColumnName="id")
     * })
     */
    private $lot;

    /**
     * @var \Facility
     *
     * @ORM\ManyToOne(targetEntity="Facility")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="facility_id", referencedColumnName="id")
     * })
     */
    private $facility;



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
     * Set key
     *
     * @param string $key
     * @return InventoryItem
     */
    public function setKey($key)
    {
        $this->key = $key;
    
        return $this;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getKey()
    {
        return $this->key;
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
     * Set container
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Container $container
     * @return InventoryItem
     */
    public function setContainer(\Zepluf\Bundle\StoreBundle\Entity\Container $container = null)
    {
        $this->container = $container;
    
        return $this;
    }

    /**
     * Get container
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Container 
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Set lot
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Lot $lot
     * @return InventoryItem
     */
    public function setLot(\Zepluf\Bundle\StoreBundle\Entity\Lot $lot = null)
    {
        $this->lot = $lot;
    
        return $this;
    }

    /**
     * Get lot
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Lot 
     */
    public function getLot()
    {
        return $this->lot;
    }

    /**
     * Set facility
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Facility $facility
     * @return InventoryItem
     */
    public function setFacility(\Zepluf\Bundle\StoreBundle\Entity\Facility $facility = null)
    {
        $this->facility = $facility;
    
        return $this;
    }

    /**
     * Get facility
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Facility 
     */
    public function getFacility()
    {
        return $this->facility;
    }
}