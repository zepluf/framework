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

    public function __construct()
    {

    }

    /**
     * [addMethod description]
     *
     * @param PaymentMethodInterface $method [description]
     */
    public function add(PaymentMethodInterface $method)
    {
        if (true === $method->isAvailable()) {
            $this->methods[$method->getCode()] = $method;
        }
    }

    /**
     * get available payment methods by code or all
     *
     * @param  null|string $code
     * @return PaymentMethodInterface
     */
    public function get($code = null)
    {
        if (null === $code) {
            return $this->methods;
        } else if (true === isset($this->methods[$code])) {
            return $this->methods[$code];
        } else {
            return false;
        }
    }
}