<?php
/**
 * Created by Rubikin Team.
 * Date: 3/12/13
 * Time: 10:09 AM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Zepluf\Bundle\StoreBundle\Component\Shipment\Carrier;

use Zepluf\Bundle\StoreBundle\Component\Shipment\ShippingRateRequest;

class FlatRate
    extends ShippingCarrierAbstract
    implements ShippingCarrierInterface
{
    protected $code = 'flatrate';

    public function getCode()
    {
        return $this->code;
    }

    public function getInfo()
    {
        // TODO: Implement getInfo() method.
    }

    public function checkCondition()
    {
        // TODO: Implement checkCondition() method.
    }

    public function getAllowMethods()
    {
        // TODO: Implement getAllowMethods() method.
    }

    public function validateData()
    {
        // TODO: Implement validateData() method.
    }

    public function processData()
    {
        // TODO: Implement processData() method.
    }

    public function renderSelection()
    {
        // TODO: Implement renderSelection() method.
    }

    public function renderForm()
    {
        // TODO: Implement renderForm() method.
    }

    public function getRates(ShippingRateRequest $request)
    {
        //TODO: replace $result array by an object
        $result = null;
        if (!$this->isAvailable()) {
            return false;
        }

        if ($this->getConfig('type') == 'O') { // per order
            $shippingPrice = $this->getConfig('price');
        } elseif ($this->getConfig('type') == 'I') { // per item
            $shippingPrice = ($data['totalQuantity'] * $this->getConfig('price')) - ($this->getFreeBoxes() * $this->getConfig('price'));
        } else {
            $shippingPrice = false;
        }

        if (false !== $shippingPrice) {
            $result = $shippingPrice;
        }
        return $result;
    }
}
