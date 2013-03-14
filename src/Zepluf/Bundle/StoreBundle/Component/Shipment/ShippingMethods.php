<?php
/**
 * Created by Rubikin Team.
 * Date: 3/13/13
 * Time: 4:28 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Zepluf\Bundle\StoreBundle\Component\Shipment;

use Zepluf\Bundle\StoreBundle\Component\Shipment\Carrier\ShippingMethodInterface;

class ShippingMethods
{
    protected $methods = array();

    public function addMethod(ShippingMethodInterface $method)
    {
        $this->methods[$method->getCode()] = $method;
    }

    /**
     * Retrieve all methods for supplied shipping data
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Get carrier by its code
     */
    public function getMethod($code)
    {
        if (!array_key_exists($code, $this->methods)) {
            return false;
        }
        return $this->methods[$code];
    }
}
