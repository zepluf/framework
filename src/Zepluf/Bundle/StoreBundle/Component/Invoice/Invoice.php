<?php
/**
 * Created by Rubikin Team.
 * Date: 3/4/13
 * Time: 5:41 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Invoice;

use \Doctrine\ORM\EntityManager;
use \Doctrine\Common\Collections\ArrayCollection;

use Zepluf\Bundle\StoreBundle\Entity\Party;
use Zepluf\Bundle\StoreBundle\Entity\ContactMechanism;
use Zepluf\Bundle\StoreBundle\Entity\Invoice as InvoiceEntity;
use Zepluf\Bundle\StoreBundle\Entity\InvoiceItem as InvoiceItemEntity;

use Zepluf\Bundle\StoreBundle\Component\Payment\Fixtures;

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

    public function __construct($doctrine)
    {
        $this->entityManager = $doctrine->getEntityManager();

        $fixtures = new Fixtures($doctrine);

        $this->create();
    }

    /**
     * create new invoice
     *
     * @param  ArrayCollection  $invoiceItems array of invoice item, includes: id, name, quantity, features
     * @return [type]                [description]
     */
    public function create(ArrayCollection $invoiceItems)
    {
        $this->invoice = new InvoiceEntity();
        $billedTo = $this->entityManager->find('Zepluf\Bundle\StoreBundle\Entity\Party', mt_rand(1, 5));
        $billedFrom = $this->entityManager->find('Zepluf\Bundle\StoreBundle\Entity\Party', mt_rand(1, 5));

        $addressedTo = $this->entityManager->find('Zepluf\Bundle\StoreBundle\Entity\ContactMechanism', mt_rand(1, 5));
        $sendTo = $this->entityManager->find('Zepluf\Bundle\StoreBundle\Entity\ContactMechanism', mt_rand(1, 5));

        // set billed to \Zepluf\Bundle\StoreBundle\Entity\Party
        $this->invoice->setBilledTo($billedTo);

        // set billed from \Zepluf\Bundle\StoreBundle\Entity\Party
        $this->invoice->setBilledFrom($billedFrom);

        // set addessed to \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism
        $this->invoice->setAddressedTo($addressedTo);

        // set send to \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism
        $this->invoice->setSentTo($sendTo);

        // set entry date
        $this->invoice->setEntryDate(new \DateTime());

        $this->entityManager->persist($this->invoice);
        $this->entityManager->flush();

        //$this->addInvoiceItems($invoice_items);
    }

    /**
     * create invoice items from ArrayCollection
     *
     * @param ArrayCollection $invoiceItems [description]
     */
    public function addInvoiceItems(ArrayCollection $invoiceItems)
    {
        $invoiceId = $this->invoice->getId();

        foreach ($invoice_items as $item) {
            // find inventory item by id \Zepluf\Bundle\StoreBundle\Entity\InventoryItem
            $inventoryItem = $this->entityManager->find('\Zepluf\Bundle\StoreBundle\Entity\InventoryItem', $item['id']);

            if ($inventoryItem) {
                $invoiceItem = new InvoiceItemEntity();

                // link to invoice
                $invoiceItem->setInvoice($this->invoice);

                // link to inventory item
                $invoiceItem->setInventoryItem($inventoryItem);

                // link to adjustment type \Zepluf\Bundle\StoreBundle\Entity\AdjustmentType
                $invoiceItem->setAdjustmentType(1);

                // link to invoice item type \Zepluf\Bundle\StoreBundle\Entity\InvoiceItemType
                $invoiceItem->setInvoiceItemType(1);

                // set quantity
                $invoiceItem->setQuantity(1);

                // set amount
                $invoiceItem->setAmount(9.75);

                // set taxable
                $invoiceItem->setIsTaxable(1);

                $this->entityManager->persist($invoiceItem);
            }
        }
    }
}