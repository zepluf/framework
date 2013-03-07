<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 *
 * @ORM\Table(name="payment")
 * @ORM\Entity
 */
class Payment
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
     * @var \DateTime
     *
     * @ORM\Column(name="effective_date", type="datetime", nullable=false)
     */
    private $effectiveDate;

    /**
     * @var string
     *
     * @ORM\Column(name="reference_number", type="string", length=255, nullable=true)
     */
    private $referenceNumber;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="decimal", nullable=true)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @var boolean
     *
     * @ORM\Column(name="type", type="boolean", nullable=false)
     */
    private $type;

    /**
     * @var \PaymentMethodType
     *
     * @ORM\ManyToOne(targetEntity="PaymentMethodType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_method_type_id", referencedColumnName="id")
     * })
     */
    private $paymentMethodType;



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
     * @return Payment
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
     * Set effectiveDate
     *
     * @param \DateTime $effectiveDate
     * @return Payment
     */
    public function setEffectiveDate($effectiveDate)
    {
        $this->effectiveDate = $effectiveDate;
    
        return $this;
    }

    /**
     * Get effectiveDate
     *
     * @return \DateTime 
     */
    public function getEffectiveDate()
    {
        return $this->effectiveDate;
    }

    /**
     * Set referenceNumber
     *
     * @param string $referenceNumber
     * @return Payment
     */
    public function setReferenceNumber($referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;
    
        return $this;
    }

    /**
     * Get referenceNumber
     *
     * @return string 
     */
    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return Payment
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
     * Set comment
     *
     * @param string $comment
     * @return Payment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    
        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set type
     *
     * @param boolean $type
     * @return Payment
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
     * Set paymentMethodType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\PaymentMethodType $paymentMethodType
     * @return Payment
     */
    public function setPaymentMethodType(\Zepluf\Bundle\StoreBundle\Entity\PaymentMethodType $paymentMethodType = null)
    {
        $this->paymentMethodType = $paymentMethodType;
    
        return $this;
    }

    /**
     * Get paymentMethodType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\PaymentMethodType 
     */
    public function getPaymentMethodType()
    {
        return $this->paymentMethodType;
    }
}