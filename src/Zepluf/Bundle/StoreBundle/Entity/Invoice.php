<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invoice
 *
 * @ORM\Table(name="invoice")
 * @ORM\Entity
 */
class Invoice
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
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255, nullable=true)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TermType", inversedBy="invoice")
     * @ORM\JoinTable(name="invoice_term",
     *   joinColumns={
     *     @ORM\JoinColumn(name="invoice_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="term_type_id", referencedColumnName="id")
     *   }
     * )
     */
    private $termType;

    /**
     * @var \Party
     *
     * @ORM\ManyToOne(targetEntity="Party")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="billed_to", referencedColumnName="id")
     * })
     */
    private $billedTo;

    /**
     * @var \Party
     *
     * @ORM\ManyToOne(targetEntity="Party")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="billed_from", referencedColumnName="id")
     * })
     */
    private $billedFrom;

    /**
     * @var \ContactMechanism
     *
     * @ORM\ManyToOne(targetEntity="ContactMechanism")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="addressed_to", referencedColumnName="id")
     * })
     */
    private $addressedTo;

    /**
     * @var \ContactMechanism
     *
     * @ORM\ManyToOne(targetEntity="ContactMechanism")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sent_to", referencedColumnName="id")
     * })
     */
    private $sentTo;

    /**
     * @var InvoiceItem|array
     *
     * @ORM\OneToMany(targetEntity="InvoiceItem", mappedBy="invoice")
     */
    private $invoiceItems;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->termType = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * @return Invoice
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
     * Set message
     *
     * @param string $message
     * @return Invoice
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Invoice
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add termType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\TermType $termType
     * @return Invoice
     */
    public function addTermType(\Zepluf\Bundle\StoreBundle\Entity\TermType $termType)
    {
        $this->termType[] = $termType;
    
        return $this;
    }

    /**
     * Remove termType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\TermType $termType
     */
    public function removeTermType(\Zepluf\Bundle\StoreBundle\Entity\TermType $termType)
    {
        $this->termType->removeElement($termType);
    }

    /**
     * Get termType
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTermType()
    {
        return $this->termType;
    }

    /**
     * Set billedTo
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Party $billedTo
     * @return Invoice
     */
    public function setBilledTo(\Zepluf\Bundle\StoreBundle\Entity\Party $billedTo = null)
    {
        $this->billedTo = $billedTo;
    
        return $this;
    }

    /**
     * Get billedTo
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Party 
     */
    public function getBilledTo()
    {
        return $this->billedTo;
    }

    /**
     * Set billedFrom
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Party $billedFrom
     * @return Invoice
     */
    public function setBilledFrom(\Zepluf\Bundle\StoreBundle\Entity\Party $billedFrom = null)
    {
        $this->billedFrom = $billedFrom;
    
        return $this;
    }

    /**
     * Get billedFrom
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\Party 
     */
    public function getBilledFrom()
    {
        return $this->billedFrom;
    }

    /**
     * Set addressedTo
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism $addressedTo
     * @return Invoice
     */
    public function setAddressedTo(\Zepluf\Bundle\StoreBundle\Entity\ContactMechanism $addressedTo = null)
    {
        $this->addressedTo = $addressedTo;
    
        return $this;
    }

    /**
     * Get addressedTo
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism 
     */
    public function getAddressedTo()
    {
        return $this->addressedTo;
    }

    /**
     * Set sentTo
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism $sentTo
     * @return Invoice
     */
    public function setSentTo(\Zepluf\Bundle\StoreBundle\Entity\ContactMechanism $sentTo = null)
    {
        $this->sentTo = $sentTo;
    
        return $this;
    }

    /**
     * Get sentTo
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism 
     */
    public function getSentTo()
    {
        return $this->sentTo;
    }

    /**
     * Add invoiceItems
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\InvoiceItem $invoiceItems
     * @return Invoice
     */
    public function addInvoiceItem(\Zepluf\Bundle\StoreBundle\Entity\InvoiceItem $invoiceItems)
    {
        $this->invoiceItems[] = $invoiceItems;
    
        return $this;
    }

    /**
     * Remove invoiceItems
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\InvoiceItem $invoiceItems
     */
    public function removeInvoiceItem(\Zepluf\Bundle\StoreBundle\Entity\InvoiceItem $invoiceItems)
    {
        $this->invoiceItems->removeElement($invoiceItems);
    }

    /**
     * Get invoiceItems
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInvoiceItems()
    {
        return $this->invoiceItems;
    }
}