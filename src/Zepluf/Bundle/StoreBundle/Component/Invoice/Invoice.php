<?php
/**
 * Created by Rubikin Team.
 * Date: 3/4/13
 * Time: 5:41 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Payment;

use \Doctrine\ORM\EntityManager;
use Zepluf\Bundle\StoreBundle\Entity\Invoice as InvoiceEntity;
use Zepluf\Bundle\StoreBundle\Entity\InvoiceItem as InvoiceItemEntity;

class Invoice
{
    /**
     * entity manager
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * invoice entity
     * @var InvoiceEntity
     */
    protected $invoice;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->invoice = new InvoiceEntity();
    }

    /**
     * create new invoice
     *
     * @param  array  $invoice_items array of invoice item, includes:
     * @return [type]                [description]
     */
    public function create($invoice_items = array())
    {
        // set billed to \Zepluf\Bundle\StoreBundle\Entity\Party
        $this->invoice->setBilledTo(1);

        // set billed from \Zepluf\Bundle\StoreBundle\Entity\Party
        $this->invoice->setBilledFrom(1);

        // set addessed to \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism
        $this->invoice->setAddressedTo(1);

        // set send to \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism
        $this->invoice->setSentTo(1);

        // set entry date
        $this->invoice->setEntryDate(new \DateTime());

        $this->entityManager->persist($this->invoice);
        $this->entityManager->flush();

        $this->addInvoiceItems($invoice_items);
    }

    public function addInvoiceItems($invoice_items = array())
    {
        $invoiceId = $this->invoice->getId();

        foreach ($invoice_items as $item) {

            $invoiceItemEntity = new InvoiceItemEntity();


            $invoiceItemEntity->setInvoice($this->invoice);

            // set adjustment type \Zepluf\Bundle\StoreBundle\Entity\AdjustmentType
            $invoiceItemEntity->setAdjustmentType(1);

            // set invoice item type \Zepluf\Bundle\StoreBundle\Entity\InvoiceItemType
            $invoiceItemEntity->setInvoiceItemType(1);

            // set inventory item \Zepluf\Bundle\StoreBundle\Entity\InventoryItem
            $invoiceItemEntity->setInventoryItem(1);
        }
    }
}