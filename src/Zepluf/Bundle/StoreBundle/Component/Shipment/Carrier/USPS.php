<?php
/**
 * Created by Rubikin Team.
 * Date: 3/18/13
 * Time: 5:17 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Zepluf\Bundle\StoreBundle\Component\Shipment\Carrier;

use Zepluf\Bundle\StoreBundle\Component\Shipment\ShippingRateRequest;

class USPS
    extends ShippingCarrierAbstract
    implements ShippingCarrierInterface
{
    protected $code = 'usps';
    protected $gatewayUrl = 'http://production.shippingapis.com/ShippingAPI.dll';

    public function getInfo()
    {
        // TODO: Implement getInfo() method.
    }

    /**
     * Build RateV4 request
     *
     * @link https://www.usps.com/business/web-tools-apis/rate-calculators-v1-7a.htm
     */
    protected function getQuotes($request)
    {
        // Ship to US
        if ($request->isUS()) {
            $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><RateV4Request/>');
            $xml->addAttribute('USERID', $request->getUserId());
            $xml->addChild('Revision', '2');

            $package = $xml->addChild('Package');
            $package->addAttribute('ID', '1ST');
            //TODO: Find a mechanism to get service
            $package->addChild('Service', $request->getService());
            //only 5 chars available
            $package->addChild('ZipOrigination', substr($request->getZipOrigination(), 0, 5));
            $package->addChild('ZipDestination', substr($request->getZipDestination(), 0, 5));
            $package->addChild('Pounds', $request->getWeightPounds());
            $package->addChild('Ounces', $request->getWeightOunces());
            $package->addChild('Container', $request->getContainer());
            $package->addChild('Size', $request->getSize());
            if ($request->getSize() == 'LARGE') {
                $package->addChild('Width', $request->getWidth());
                $package->addChild('Length', $request->getLength());
                $package->addChild('Height', $request->getHeight());
                if ($request->getContainer() == 'NONRECTANGULAR' || $request->getContainer() == 'VARIABLE') {
                    $package->addChild('Girth', $request->getGirth());
                }
            }
            $package->addChild('Machinable', $request->getMachinable());
        } else {
            $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><IntlRateV2Request/>');
            $xml->addAttribute('USERID', $request->getUserId());
            $xml->addChild('Revision', '2');

            $package = $xml->addChild('Package');
            $package->addAttribute('ID', '1ST');
            $package->addChild('Pounds', $request->getWeightPounds());
            $package->addChild('Ounces', $request->getWeightOunces());
            $package->addChild('MailType', 'All');
            $package->addChild('ValueOfContents', $request->getValue());
            $package->addChild('Country', $request->getDestCountryName());
            $package->addChild('Container', $request->getContainer());
            $package->addChild('Size', $request->getSize());
            if ($request->getSize() == 'LARGE') {
                $package->addChild('Width', $request->getWidth());
                $package->addChild('Length', $request->getLength());
                $package->addChild('Height', $request->getHeight());
                if ($request->getContainer() == 'NONRECTANGULAR') {
                    $package->addChild('Girth', $request->getGirth());
                }
            }
        }

        $xmlRequest = $xml->asXML();

        try {
            $url = $this->getConfig('gateway');
            if (!$url) {
                $url = $this->gatewayUrl;
            }
            $api = 'RateV4';
            $APIRequest = urlencode("$url?API=$api&XML=$xmlRequest");
            $xmlResponse = new \SimpleXMLElement($APIRequest, NULL, TRUE);

        } catch (\Exception $e) {

        }

        return $this->parseXMLResponse($xmlResponse);
    }

    protected function parseXMLResponse($response)
    {

    }

    public function getAllowMethods()
    {
        // TODO: Implement getAllowMethods() method.
    }

    public function getRates(ShippingRateRequest $request)
    {
        $result = $this->getQuotes($request);

        return $result;
    }

    public function setGateway($gateway)
    {
        $this->gateway = $gateway;

        return $this;
    }
}
