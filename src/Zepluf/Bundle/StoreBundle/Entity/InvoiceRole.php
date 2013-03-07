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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @var \InvoiceRoleType
     *
     * @ORM\ManyToOne(targetEntity="InvoiceRoleType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="invoice_role_type_id", referencedColumnName="id")
     * })
     */
    private $invoiceRoleType;

    /**
     * @var \Party
     *
     * @ORM\ManyToOne(targetEntity="Party")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="party_id", referencedColumnName="id")
     * })
     */
    private $party;



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
     * Set invoice
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Invoice $invoice
     * @return InvoiceRole
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
     * Set invoiceRoleType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\InvoiceRoleType $invoiceRoleType
     * @return InvoiceRole
     */
    public function setInvoiceRoleType(\Zepluf\Bundle\StoreBundle\Entity\InvoiceRoleType $invoiceRoleType = null)
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
    public function setParty(\Zepluf\Bundle\StoreBundle\Entity\Party $party = null)
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