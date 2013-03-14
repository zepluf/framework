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

use Zepluf\Bundle\StoreBundle\Component\Payment\Payment;
use Zepluf\Bundle\StoreBundle\Component\Payment\StorageHandler\PaymentArrayStorageHandler;

/**
 *
 */
class PaymentFactory
{
    /**
     *  Logic code to get the suitable storage handler
     */
    public function get(PaymentArrayStorageHandler $paymentStorageHandler)
    {
        $payment = new Payment();
        $payment->setStorageHandler($paymentStorageHandler);

        return $payment;
    }
}