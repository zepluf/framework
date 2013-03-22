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

class UPS
    extends ShippingCarrierAbstract
    implements ShippingCarrierInterface
{
    protected $code = 'ups';

    protected $xmlGatewayUrl = 'https://www.ups.com/ups.app/xml/Rate';
    protected $cgiGatewayUrl = 'http://www.ups.com:80/using/services/rave/qcostcgi.cgi';

    public function convertValue($type, $code)
    {
        $repo = array(
            'service' => array('14' => 'Next Day Air Early AM',
                '01' => 'Next Day Air',
                '13' => 'Next Day Air Saver',
                '59' => '2nd Day Air AM',
                '02' => '2nd Day Air',
                '12' => '3 Day Select',
                '03' => 'Ground',
                '11' => 'Standard',
                '07' => 'Worldwide Express',
                '54' => 'Worldwide Express Plus',
                '08' => 'Worldwide Expedited',
                '65' => 'Saver',
                '82' => 'UPS Today Standard',
                '83' => 'UPS Today Dedicated Courier',
                '84' => 'UPS Today Intercity',
                '85' => 'UPS Today Express',
                '86' => 'UPS Today Express Saver',
                '96' => 'UPS WorldWide Express Freight',
            )
        );
        if (!isset($repo[$type])) {
            return false;
        } elseif ('' === $code) {
            return $repo[$type];
        }

        if (!isset($repo[$type][$code])) {
            return false;
        } else {
            return $repo[$type][$code];
        }
    }


    public function getCode()
    {
        return $this->code;
    }

    public function getInfo()
    {
        // TODO: Implement getInfo() method.
    }

    public function getAllowMethods()
    {
        // TODO: Implement getAllowMethods() method.
    }

    public function getRates(ShippingRateRequest $request)
    {
        $canonRequest = $this->convertRequest($request);
        $quote = $this->getQuotes($canonRequest);

        return $quote;
    }

    public function getQuotes($request)
    {
//        if ($this->getConfig('type') === 'cgi') {
//            $this->getCgiQuotes($request);
//        } else {
//            $this->getXMLQuotes($request);
//        }
        return $this->getXMLQuotes($request);
    }

    protected function convertRequest(ShippingRateRequest $request)
    {

    }

    /**
     * Build XML request, hit the UPS web service and return some
     * rate information.
     **/
    protected function getXMLQuotes($request)
    {
        //TODO: What's request option?

        /**
         * Parse info
         */
        // Authentication
//        $accessLicenseNumber = $this->getConfig('access_key');
//        $userId = $this->getConfig('user_id');
//        $password = $this->getConfig('password');

        $shipperNumber = '06V2A1';
        $accessLicenseNumber = '9CB176ED636EF975';
        $userId = 'vu nguyen';
        $password = '635Doxuanhop';

        if ($request['requestOption'] = 'Shop') {
            // Service code is not relevant when we're asking ALL possible services' rates
            $serviceCode = null;
        } else {
            $serviceCode = $request['service']['code'];
        }

        $xmlRequest =
            <<<_XMLAuth_
                        <?xml version="1.0"?>
        <AccessRequest xml:lang="en-US">
            <AccessLicenseNumber>$accessLicenseNumber</AccessLicenseNumber>
            <UserId>$userId</UserId>
            <Password>$password</Password>
        </AccessRequest>
_XMLAuth_;

        //RatingServiceRequest
        $xmlRequest .=
            <<<_XMLRequest_
                    <?xml version="1.0"?>
        <RatingServiceSelectionRequest>
            <Request>
                <TransactionReference>
                    <CustomerContext>Rating and Service</CustomerContext>
                    <XpciVersion>1.0</XpciVersion>
                </TransactionReference>
                <RequestAction>Rate</RequestAction>
                <RequestOption>{$request['requestOption']}</RequestOption>
            </Request>
            <PickupType>
                <Code>01</Code>
                <Description>Daily Pickup</Description>
            </PickupType>
             <Shipment>
                <Shipper>

_XMLRequest_;
//        if ($this->getConfig('negotiated') && ($shipperNumber = $this->getConfig('shipper_number'))) {
//            $xmlRequest .= "<ShipperNumber>{$shipperNumber}</ShipperNumber>";
//        }
        $xmlRequest .= "<ShipperNumber>{$shipperNumber}</ShipperNumber>";
        //TODO: Condition for Shipper address

        $xmlRequest .=
            <<<_XMLRequest_
                    <Address>
                      <PostalCode>90002</PostalCode>
                      <CountryCode>US</CountryCode>
                    </Address>
                </Shipper>
                <ShipTo>
                    <Address>
                        <PostalCode>{$request['destZip']}</PostalCode>
                        <CountryCode>{$request['destCountry']}</CountryCode>
                    </Address>
                </ShipTo>

                <ShipFrom>
                    <Address>
                        <PostalCode>{$request['origZip']}</PostalCode>
                        <CountryCode>{$request['origCountry']}</CountryCode>
    			    </Address>
                </ShipFrom>
_XMLRequest_;
        if ($serviceCode !== null) {
            $xmlRequest .=
                "<Service>" .
                    "<Code>{$serviceCode}</Code>" .
                    "<Description>{$request['service']['description']}</Description>" .
                    "</Service>";
        }

        $xmlRequest .=
            <<<_XMLRequest_
                <Package>
                    <PackagingType>
                        <Code>{$request['container']}</Code>
                    </PackagingType>
                    <PackageWeight>
                        <UnitOfMeasurement>
                            <Code>{$request['unitOfMeasurement']}</Code>
                        </UnitOfMeasurement>
                        <Weight>{$request['weight']}</Weight>
                    </PackageWeight>
                </Package>
_XMLRequest_;
//        if ($this->getConfig('negotiated')) {
//            $xmlRequest .= "<RateInformation><NegotiatedRatesIndicator/></RateInformation>";
//        }

        $xmlRequest .=
            <<<_XMLRequest_
            </Shipment>
        </RatingServiceSelectionRequest>
_XMLRequest_;

        $debugData = array('request' => $xmlRequest);
        try {
            $rsrcCurl = curl_init($this->xmlGatewayUrl);
            curl_setopt($rsrcCurl, CURLOPT_HEADER, 0);
            curl_setopt($rsrcCurl, CURLOPT_POST, 1);
            curl_setopt($rsrcCurl, CURLOPT_TIMEOUT, 60);
            curl_setopt($rsrcCurl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($rsrcCurl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($rsrcCurl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($rsrcCurl, CURLOPT_POSTFIELDS, $xmlRequest);

            $xmlResponse = curl_exec($rsrcCurl);
            $debugData['result'] = $xmlResponse;
        } catch (\Exception $e) {
            $debugData['result'] = array('error' => $e->getMessage(), 'code' => $e->getCode());
            $xmlResponse = '';
        }
        $objResult = new \SimpleXMLElement($xmlResponse);

        return $this->parseXMLResponse($objResult);
    }

    protected function parseXMLResponse(\SimpleXMLElement $response)
    {
        //TODO: Parse data
        $costArr = array();

        $negotiatedArr = $response->xpath("//RatingServiceSelectionResponse/RatedShipment/NegotiatedRates");
        $negotiatedActive = $this->getConfig('negotiated')
            && $this->getConfig('shipper_number')
            && !empty($negotiatedArr);

        foreach ($response->RatedShipment as $rate) {
            $code = (string)$rate->Service->Code;
            $code = $this->convertValue('service', $code);
            if ($code === false) {
                continue;
            }
            if ($negotiatedActive) {
                $cost = $rate->NegotiatedRates->NetSummaryCharges->GrandTotal->MonetaryValue;
                $currency = $rate->NegotiatedRates->NetSummaryCharges->GrandTotal->CurrencyCode;
            } else {
                $cost = $rate->TotalCharges->MonetaryValue;
                $currency = $rate->TotalCharges->CurrencyCode;
            }
            $cost = (float)$cost;
            $currency = (string)$currency;

            $costArr[$code] = array('currencyCode' => $currency, 'cost' => $cost);
        }

        $quote = new ShippingQuote($this->getCode());
        $quote->setQuotes($costArr);

        return $quote;
    }

    /**
     * Hit the UPS web service and return some
     * rate information.
     **/
    protected function getCgiQuotes($request)
    {
    }

}
