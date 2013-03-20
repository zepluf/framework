<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InvoiceItem
 *
 * @ORM\Table(name="invoice_item")
 * @ORM\Entity
 */
class InvoiceItem
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
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="decimal", nullable=false)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="item_description", type="string", length=255, nullable=true)
     */
    private $itemDescription;

    /**
     * @var boolean
     *
     * @ORM\Column(name="type", type="boolean", nullable=true)
     */
    private $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_taxable", type="boolean", nullable=false)
     */
    private $isTaxable;

    /**
     * @var \Invoice
     *
     * @ORM\ManyToOne(targetEntity="Invoice")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="invoice_id", referencedColumnName="id")
     * })
     */
    private $invoice;

    /**
     * @var \AdjustmentType
     *
     * @ORM\ManyToOne(targetEntity="AdjustmentType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="adjustment_type_id", referencedColumnName="id")
     * })
     */
    private $adjustmentType;

    /**
     * @var \InvoiceItemType
     *
     * @ORM\ManyToOne(targetEntity="InvoiceItemType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="invoice_item_type_id", referencedColumnName="id")
     * })
     */
    private $invoiceItemType;

    /**
     * @var \InventoryItem
     *
     * @ORM\ManyToOne(targetEntity="InventoryItem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inventory_item_id", referencedColumnName="id")
     * })
     */
    private $inventoryItem;



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
     * @return InvoiceItem
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
     * Set amount
     *
     * @param float $amount
     * @return InvoiceItem
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set itemDescription
     *
     * @param string $itemDescription
     * @return InvoiceItem
     */
    public function setItemDescription($itemDescription)
    {
        $this->itemDescription = $itemDescription;
    
        return $this;
    }

    /**
     * Get itemDescription
     *
     * @return string 
     */
    public function getItemDescription()
    {
        return $this->itemDescription;
    }

    /**
     * Set type
     *
     * @param boolean $type
     * @return InvoiceItem
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return boolean 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set isTaxable
     *
     * @param boolean $isTaxable
     * @return InvoiceItem
     */
    public function setIsTaxable($isTaxable)
    {
        $this->isTaxable = $isTaxable;
    
        return $this;
    }

    /**
     * Get isTaxable
     *
     * @return boolean 
     */
    public function getIsTaxable()
    {
        return $this->isTaxable;
    }

    /**
     * Set invoice
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Invoice $invoice
     * @return InvoiceItem
     */
    public function setInvoice(\Zepluf\Bundle\StoreBundle\Entity\Invoice $invoice = null)
    {
        $this->invoice = $invoice;
    
        return $this;
    }

    /**
     * Get invoice
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Invoice 
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * Set adjustmentType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\AdjustmentType $adjustmentType
     * @return InvoiceItem
     */
    public function setAdjustmentType(\Zepluf\Bundle\StoreBundle\Entity\AdjustmentType $adjustmentType = null)
    {
        $this->adjustmentType = $adjustmentType;
    
        return $this;
    }

    /**
     * Get adjustmentType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\AdjustmentType 
     */
    public function getAdjustmentType()
    {
        return $this->adjustmentType;
    }

    /**
     * Set invoiceItemType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\InvoiceItemType $invoiceItemType
     * @return InvoiceItem
     */
    public function setInvoiceItemType(\Zepluf\Bundle\StoreBundle\Entity\InvoiceItemType $invoiceItemType = null)
    {
        $this->invoiceItemType = $invoiceItemType;
    
        return $this;
    }

    /**
     * Get invoiceItemType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\InvoiceItemType 
     */
    public function getInvoiceItemType()
    {
        return $this->invoiceItemType;
    }

    /**
     * Set inventoryItem
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\InventoryItem $inventoryItem
     * @return InvoiceItem
     */
    public function setInventoryItem(\Zepluf\Bundle\StoreBundle\Entity\InventoryItem $inventoryItem = null)
    {
        $this->inventoryItem = $inventoryItem;
    
        return $this;
    }

    /**
     * Get inventoryItem
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\InventoryItem 
     */
    public function getInventoryItem()
    {
        return $this->inventoryItem;
    }
}