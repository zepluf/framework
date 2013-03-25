<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InvoiceRole
 *
 * @ORM\Table(name="invoice_role")
 * @ORM\Entity
 */
class InvoiceRole
{
    /**
     * @var \Invoice
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Invoice")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="invoice_id", referencedColumnName="id")
     * })
     */
    private $invoice;

    /**
     * @var \InvoiceRoleType
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="InvoiceRoleType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="invoice_role_type_id", referencedColumnName="id")
     * })
     */
    private $invoiceRoleType;

    /**
     * @var \Party
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Party")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="party_id", referencedColumnName="id")
     * })
     */
    private $party;



    /**
     * Set invoice
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Invoice $invoice
     * @return InvoiceRole
     */
    public function setInvoice(\Zepluf\Bundle\StoreBundle\Entity\Invoice $invoice)
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
     * Set invoiceRoleType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\InvoiceRoleType $invoiceRoleType
     * @return InvoiceRole
     */
    public function setInvoiceRoleType(\Zepluf\Bundle\StoreBundle\Entity\InvoiceRoleType $invoiceRoleType)
    {
        $this->invoiceRoleType = $invoiceRoleType;
    
        return $this;
    }

    /**
     * Get invoiceRoleType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\InvoiceRoleType 
     */
    public function getInvoiceRoleType()
    {
        return $this->invoiceRoleType;
    }

    /**
     * Set party
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Party $party
     * @return InvoiceRole
     */
    public function setParty(\Zepluf\Bundle\StoreBundle\Entity\Party $party)
    {
        $this->party = $party;
    
        return $this;
    }

    /**
     * Get party
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Party 
     */
    public function getParty()
    {
        return $this->party;
    }
}