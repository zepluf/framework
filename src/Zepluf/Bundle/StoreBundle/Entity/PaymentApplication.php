<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaymentApplication
 *
 * @ORM\Table(name="payment_application")
 * @ORM\Entity
 */
class PaymentApplication
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
     * @ORM\Column(name="sequence_id", type="string", length=255, nullable=true)
     */
    private $sequenceId;

    /**
     * @var float
     *
     * @ORM\Column(name="amount_applied", type="decimal", nullable=false)
     */
    private $amountApplied;

    /**
     * @var \Payment
     *
     * @ORM\ManyToOne(targetEntity="Payment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_id", referencedColumnName="id")
     * })
     */
    private $payment;

    /**
     * @var \InvoiceItem
     *
     * @ORM\ManyToOne(targetEntity="InvoiceItem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="invoice_item_id", referencedColumnName="id")
     * })
     */
    private $invoiceItem;



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
     * Set sequenceId
     *
     * @param string $sequenceId
     * @return PaymentApplication
     */
    public function setSequenceId($sequenceId)
    {
        $this->sequenceId = $sequenceId;
    
        return $this;
    }

    /**
     * Get sequenceId
     *
     * @return string 
     */
    public function getSequenceId()
    {
        return $this->sequenceId;
    }

    /**
     * Set amountApplied
     *
     * @param float $amountApplied
     * @return PaymentApplication
     */
    public function setAmountApplied($amountApplied)
    {
        $this->amountApplied = $amountApplied;
    
        return $this;
    }

    /**
     * Get amountApplied
     *
     * @return float 
     */
    public function getAmountApplied()
    {
        return $this->amountApplied;
    }

    /**
     * Set payment
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Payment $payment
     * @return PaymentApplication
     */
    public function setPayment(\Zepluf\Bundle\StoreBundle\Entity\Payment $payment = null)
    {
        $this->payment = $payment;
    
        return $this;
    }

    /**
     * Get payment
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Payment 
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set invoiceItem
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\InvoiceItem $invoiceItem
     * @return PaymentApplication
     */
    public function setInvoiceItem(\Zepluf\Bundle\StoreBundle\Entity\InvoiceItem $invoiceItem = null)
    {
        $this->invoiceItem = $invoiceItem;
    
        return $this;
    }

    /**
     * Get invoiceItem
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\InvoiceItem 
     */
    public function getInvoiceItem()
    {
        return $this->invoiceItem;
    }
}