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

use Symfony\Component\Config\Definition\Exception\Exception;
use Zepluf\Bundle\StoreBundle\Component\Shipment\Carrier\ShippingCarrierInterface;

class ShippingMethods
{
    protected $carriers = array();

    public function addCarrier(ShippingCarrierInterface $carrier)
    {
        $this->carriers[$carrier->getCode()] = $carrier;

        return $this;
    }

    /**
     * Retrieve all methods for supplied shipping data
     */
    public function getCarriers()
    {
        return $this->carriers;
    }

    /**
     * Get carrier by its code
     */
    public function getCarrier($code)
    {
        if (!array_key_exists($code, $this->carriers)) {
            return false;
        }
        return $this->carriers[$code];
    }

    // OPTIONAL
    public function getRates(ShippingRateRequest $request)
    {
        $result = array();
        $carrierCode = $request->getCarrier();

        //  Limit carrier
        if ($carrierCode) {
            // Valid carrier
            if ($carrier = $this->carriers[$carrierCode]) {
                $result[] = $carrier->getRates($request);
            } else {
                throw new \Exception('Invalid carrier');
            }
        } //  All carrier
        else {
            foreach ($this->carriers as $carrier) {
                if ($carrier->getRates($request)) {
                    $result[$carrier->getCode()] = $carrier->getRates($request);
                }
            }
        }

        return $result;
    }
}
