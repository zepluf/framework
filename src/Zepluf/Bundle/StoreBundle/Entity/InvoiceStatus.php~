<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InvoiceStatus
 *
 * @ORM\Table(name="invoice_status")
 * @ORM\Entity
 */
class InvoiceStatus
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
     * @ORM\Column(name="entry_date", type="datetime", nullable=false)
     */
    private $entryDate;

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
     * @var \InvoiceStatusType
     *
     * @ORM\ManyToOne(targetEntity="InvoiceStatusType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="invoice_status_type_id", referencedColumnName="id")
     * })
     */
    private $invoiceStatusType;



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
     * Set entryDate
     *
     * @param \DateTime $entryDate
     * @return InvoiceStatus
     */
    public function setEntryDate($entryDate)
    {
        $this->entryDate = $entryDate;
    
        return $this;
    }

    /**
     * Get entryDate
     *
     * @return \DateTime 
     */
    public function getEntryDate()
    {
        return $this->entryDate;
    }

    /**
     * Set invoice
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Invoice $invoice
     * @return InvoiceStatus
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
     * Set invoiceStatusType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\InvoiceStatusType $invoiceStatusType
     * @return InvoiceStatus
     */
    public function setInvoiceStatusType(\Zepluf\Bundle\StoreBundle\Entity\InvoiceStatusType $invoiceStatusType = null)
    {
        $this->invoiceStatusType = $invoiceStatusType;
    
        return $this;
    }

    /**
     * Get invoiceStatusType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\InvoiceStatusType 
     */
    public function getInvoiceStatusType()
    {
        return $this->invoiceStatusType;
    }
}