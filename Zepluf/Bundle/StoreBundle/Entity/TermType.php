<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TermType
 *
 * @ORM\Table(name="term_type")
 * @ORM\Entity
 */
class TermType
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
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Invoice", mappedBy="termType")
     */
    private $invoice;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="termType")
     */
    private $product;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->invoice = new \Doctrine\Common\Collections\ArrayCollection();
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set description
     *
     * @param string $description
     * @return TermType
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
     * Set content
     *
     * @param string $content
     * @return TermType
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Add invoice
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Invoice $invoice
     * @return TermType
     */
    public function addInvoice(\Zepluf\Bundle\StoreBundle\Entity\Invoice $invoice)
    {
        $this->invoice[] = $invoice;
    
        return $this;
    }

    /**
     * Remove invoice
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Invoice $invoice
     */
    public function removeInvoice(\Zepluf\Bundle\StoreBundle\Entity\Invoice $invoice)
    {
        $this->invoice->removeElement($invoice);
    }

    /**
     * Get invoice
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * Add product
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Product $product
     * @return TermType
     */
    public function addProduct(\Zepluf\Bundle\StoreBundle\Entity\Product $product)
    {
        $this->product[] = $product;
    
        return $this;
    }

    /**
     * Remove product
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Product $product
     */
    public function removeProduct(\Zepluf\Bundle\StoreBundle\Entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduct()
    {
        return $this->product;
    }
}