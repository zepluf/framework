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

use Zepluf\Bundle\StoreBundle\Component\Payment\PaymentMethodInterface;
use Zepluf\Bundle\StoreBundle\Component\Payment\Method\Cheque;

use Zepluf\Bundle\StoreBundle\Component\Invoice\Invoice;

use Zepluf\Bundle\StoreBundle\Entity\Payment as PaymentEntity;
use Zepluf\Bundle\StoreBundle\Entity\PaymentMethodType as PaymentMethodTypeEntity;
use Zepluf\Bundle\StoreBundle\Entity\PaymentApplication as PaymentApplicationEntity;
use Zepluf\Bundle\StoreBundle\Entity\Invoice as InvoiceEntity;
use Zepluf\Bundle\StoreBundle\Entity\InvoiceItem as InvoiceItemEntity;

/**
*
*/
class Payment
{
    protected $entityManager;

    /**
     * payment entity
     * @var PaymentEntity
     */
    protected $payment = false;

    /**
     * constructor
     * @param EntityManager $entityManager
     */
    public function __construct($doctrine)
    {
        $this->entityManager = $doctrine->getEntityManager();

        // $this->create(new Cheque(),
        //     $this->entityManager->find('Zepluf\Bundle\StoreBundle\Component\Invoice\Invoice', 1)
        // );
    }

    /**
     * @param array $data ('payment_method' => array(), 'invoice_items' => array(). ...)
     * @throws \Exception
     */
    public function create(PaymentMethodInterface $paymentMethod, InvoiceEntity $invoice)
    {
        $this->payment = new PaymentEntity();

        /**
         * @todo set payment method type for current payment
         * @var Zepluf\Bundle\StoreBundle\Entity\PaymentMethodType
         */
        $paymentMethodType = $this->entityManager->find('Zepluf\Bundle\StoreBundle\Entity\PaymentMethodType', mt_rand(1, 5));
        $this->payment->setPaymentMethodType($paymentMethodType);

        // set effective date
        $this->payment->setEffectiveDate(new \DateTime());

        // set payment type: receipt, disbursement
        $this->payment->setType(1);

        // persist payment and new payment method type
        $this->entityManager->persist($this->payment);
        $this->entityManager->persist($paymentMethodType);

        // get all invoice items
        $invoiceItems = $invoice->getInvoiceItems();

        foreach ($invoiceItems as $invoiceItem) {
            $paymentApplication = new PaymentApplicationEntity();

            $paymentApplication->setPayment($this->payment);
            $paymentApplication->setInvoiceItem($invoiceItem);
            $paymentApplication->setAmountApplied(mt_rand(1, 5));

            $this->entityManager->persist($paymentApplication);
        }

        $this->entityManager->flush();
    }
}