<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InvoiceTerm
 *
 * @ORM\Table(name="invoice_term")
 * @ORM\Entity
 */
class InvoiceTerm
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
     * @var \TermType
     *
     * @ORM\ManyToOne(targetEntity="TermType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="term_type_id", referencedColumnName="id")
     * })
     */
    private $termType;



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
     * @return InvoiceTerm
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
     * Set termType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\TermType $termType
     * @return InvoiceTerm
     */
    public function setTermType(\Zepluf\Bundle\StoreBundle\Entity\TermType $termType = null)
    {
        $this->termType = $termType;
    
        return $this;
    }

    /**
     * Get termType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\TermType 
     */
    public function getTermType()
    {
        return $this->termType;
    }
}