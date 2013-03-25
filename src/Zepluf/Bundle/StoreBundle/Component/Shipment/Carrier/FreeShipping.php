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

use Zepluf\Bundle\StoreBundle\Component\Shipment\ShippingQuote;
use Zepluf\Bundle\StoreBundle\Component\Shipment\ShippingRateRequest;

class FreeShipping
    extends ShippingCarrierAbstract
    implements ShippingCarrierInterface
{
    protected $code = 'freeshipping';

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

    /**
     * @param ShippingRateRequest $request
     * @return ShippingQuote
     */
    public function getRates(ShippingRateRequest $request)
    {
        $quote = new ShippingQuote($this->getCode());
        $costArray = array();

        //  TODO: CurrencyCode???
        // $costArray['method'] => ( 'currencyCode' => 'USD', 'cost' => 10)
        // Freeshipping has onely 1 method
        $costArray[$this->getCode()] = array('currencyCode' => 'USD', 'cost' => 0);
        $quote->setQuotes($costArray);
        return $quote;
    }
}
