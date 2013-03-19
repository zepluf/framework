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

use Zepluf\Bundle\StoreBundle\Component\Payment\Method\PaymentMethodInterface;

/**
*
*/
class PaymentMethods
{
    /**
     * @var list of available payment methods
     */
    protected $paymentMethods = array();
    // protected $storageHandlers;

    public function __construct()
    {

    }

    /**
     * [addMethod description]
     *
     * @param PaymentMethodInterface $method [description]
     */
    public function addMethod(PaymentMethodInterface $method)
    {
        if (true === $method->isAvailable()) {
            $this->methods[$method->getCode()] = $method;
        }
    }

    public function getMethod($code = null)
    {
        if (null === $code) {
            return $this->getMethods();
        } else if (isset($this->methods[$code])) {
            return $this->methods[$code];
        } else {
            return false;
        }
    }

    public function getMethods()
    {
        return $this->methods;
    }
}