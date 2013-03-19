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
use Zepluf\Bundle\StoreBundle\Entity\Payment as PaymentEntity;

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
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $data ('payment_method' => array(), 'invoice_items' => array(). ...)
     * @throws \Exception
     */
    public function create($data)
    {
        $this->payment = new PaymentEntity();

        // set payment effective date
        $this->payment->setEffectiveDate(new \DateTime());

        //If ship from address is empty, it's shopkeeper contact by default
        if (isset($data['ShippedFromContactMechanism'])) {
            $payment->setShippedFromContactMechanism($data['ship_from']);
        }
        if (isset($data['ship_from'])) {
            $payment->setShippedToContactMechanism($data['ship_to']);
        }


        //set payment Item
        foreach ($data['items'] as $item) {
            $paymentItem = new paymentItem();

            //logical code to set info for paymentItem

            $paymentItem->setpayment($payment);
            $payment->addpaymentItem($paymentItem);
        }

        if (!$error) {
            $this->payment = $payment;
        }

        if ($this->payment) {
            // persists the payment
            $this->entityManager->persist($this->payment);
            try {
                $this->entityManager->flush();
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }
}