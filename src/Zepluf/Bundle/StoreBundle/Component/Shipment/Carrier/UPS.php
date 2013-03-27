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
    protected $request;

//    public function convertValue($type, $code)
//    {
//        $repo = array(
//            'service' => array('14' => 'Next Day Air Early AM',
//                '01' => 'Next Day Air',
//                '13' => 'Next Day Air Saver',
//                '59' => '2nd Day Air AM',
//                '02' => '2nd Day Air',
//                '12' => '3 Day Select',
//                '03' => 'Ground',
//                '11' => 'Standard',
//                '07' => 'Worldwide Express',
//                '54' => 'Worldwide Express Plus',
//                '08' => 'Worldwide Expedited',
//                '65' => 'Saver',
//                '82' => 'UPS Today Standard',
//                '83' => 'UPS Today Dedicated Courier',
//                '84' => 'UPS Today Intercity',
//                '85' => 'UPS Today Express',
//                '86' => 'UPS Today Express Saver',
//                '96' => 'UPS WorldWide Express Freight'
//            ),
//            'container' => array(
//                'CP' => '00', // Customer Packaging
//                'UL' => '01', // UPS Letter
//                'PKG' => '02', // Package
//                'T' => '03', // Tube
//                'PAK' => '04', // PAK
//                'EB' => '21', // Express Box
//                '25B' => '24', // 25KG Box
//                '10B' => '25', // 10KG Box
//                'PLT' => '30', // Pallet
//                'SEB' => '2a', // Small Express Box
//                'MEB' => '2b', // Medium Express Box
//                'LEB' => '2c', // Large Express Box
//            )
//        );
//        if (!isset($repo[$type])) {
//            return false;
//        } elseif ('' === $code) {
//            return $repo[$type];
//        }
//
//        if (!isset($repo[$type][$code])) {
//            return false;
//        } else {
//            return $repo[$type][$code];
//        }
//    }
    public function convertValue($type, $code)
    {
        $data = $this->getConfig('data');
        if (!isset($data[$type])) {
            return false;
        } elseif ('' === $code) {
            return $data[$type];
        }

        if (!isset($data[$type][$code])) {
            return false;
        } else {
            return $data[$type][$code];
        }
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
        $r = array();
        if ($request->getMethod()) {
            $r['requestOption'] = 'Rate';
            $r['service']['code'] = $request->getMethod();
            $r['service']['description'] = '';
        } else {
            $r['requestOption'] = 'Shop';
        }

        if ($request->getOriginationCountry()) {
            $r['origCountry'] = $request->getOriginationCountry();
        }
        if ($request->getOriginationPostal()) {
            $r['origPostal'] = $request->getOriginationPostal();
        }
        if ($request->getOriginationCity()) {
            $r['origCity'] = $request->getOriginationCity();
        }
        if ($request->getOriginationStateProvince()) {
            $r['origRegion'] = $request->getOriginationStateProvince();
        }
        if ($request->getDestinationCountry()) {
            $r['destCountry'] = $request->getDestinationCountry();
        }
        if ($request->getDestinationPostal()) {
            $r['destPostal'] = $request->getDestinationPostal();
        }
        if ($request->getDestinationCity()) {
            $r['destCity'] = $request->getDestinationCity();
        }
        if ($request->getDestinationStateProvince()) {
            $r['destRegion'] = $request->getDestinationStateProvince();
        }

        if ($request->getPackageContainer()) {
            $r['packageType'] = $this->convertValue('container', $request->getPackageContainer());
        } else {
            $r['packageType'] = $this->convertValue('container', $this->getConfig('container'));
        }
        if ($request->getPackageWeight()) {
            $r['packageWeight'] = $request->getPackageWeight();
        }
        if ($request->getPackageUOM()) {
            $r['packageUnitOfMeasurement'] = $request->getPackageUOM();
        } else {
            $r['packageUnitOfMeasurement'] = $this->getConfig('UOM');
        }


        return $r;
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
        $accessLicenseNumber = $this->getConfig('access_license_number');
        $userId = $this->getConfig('user_id');
        $password = $this->getConfig('password');

        if ($request['requestOption'] === 'Shop') {
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

        if ($this->getConfig('negotiated') && ($shipperNumber = $this->getConfig('shipper_number'))) {
            $xmlRequest .= "<ShipperNumber>{$shipperNumber}</ShipperNumber>";
        }
        //TODO: Condition for Shipper address

        $xmlRequest .=
            <<<_XMLRequest_
                    <Address>
                      <PostalCode>{$request['origPostal']}</PostalCode>
                        <CountryCode>{$request['origCountry']}</CountryCode>
                        <StateProvinceCode>{$request['origRegion']}</StateProvinceCode>
                        <City>{$request['origCity']}</City>
                    </Address>
                </Shipper>
                <ShipTo>
                    <Address>
                        <PostalCode>{$request['destPostal']}</PostalCode>
                        <CountryCode>{$request['destCountry']}</CountryCode>
                        <StateProvinceCode>{$request['destRegion']}</StateProvinceCode>
                        <City>{$request['destCity']}</City>
                    </Address>
                </ShipTo>

                <ShipFrom>
                    <Address>
                        <PostalCode>{$request['origPostal']}</PostalCode>
                        <CountryCode>{$request['origCountry']}</CountryCode>
                        <StateProvinceCode>{$request['origRegion']}</StateProvinceCode>
                        <City>{$request['origCity']}</City>
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
                        <Code>{$request['packageType']}</Code>
                    </PackagingType>
                    <PackageWeight>
                        <UnitOfMeasurement>
                            <Code>{$request['packageUnitOfMeasurement']}</Code>
                        </UnitOfMeasurement>
                        <Weight>{$request['packageWeight']}</Weight>
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

            $response = curl_exec($rsrcCurl);

            $debugData['result'] = $response;
        } catch (\Exception $e) {
            $debugData['result'] = array('error' => $e->getMessage(), 'code' => $e->getCode());
            $response = '';
        }
        $objResult = new \SimpleXMLElement($response);

        return $this->parseXMLResponse($objResult);
    }

    protected function parseXMLResponse(\SimpleXMLElement $response)
    {
        //TODO: Parse data

        $arr = $response->Response->ResponseStatusCode;
        $success = (int)$arr[0];

        if (1 === $success) {
            $costArr = array();

            $negotiatedArr = $response->RatedShipment->NegotiatedRates;
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
        } else {
            return false;
        }
    }

    /**
     * Hit the UPS web service and return some
     * rate information.
     **/
//    protected function getCgiQuotes($request)
//    {
//        try {
//            $mode = array
//            (
//                'soap_version' => 'SOAP_1_1', // use soap 1.1 client
//                'trace' => 1
//            );
//
//            // initialize soap client
//            $client = new SoapClient($wsdl, $mode);
//
//            //set endpoint url
//            $client->__setLocation($endpointurl);
//
//            //create soap header
//            $usernameToken['Username'] = $userid;
//            $usernameToken['Password'] = $passwd;
//            $serviceAccessLicense['AccessLicenseNumber'] = $access;
//            $upss['UsernameToken'] = $usernameToken;
//            $upss['ServiceAccessToken'] = $serviceAccessLicense;
//
//            $header = new SoapHeader('http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0', 'UPSSecurity', $upss);
//            $client->__setSoapHeaders($header);
//
//            //get response
//            $response = $client->__soapCall($operation, array(processFreightRate()));
//
//            //get status
//            echo "Response Status: " . $response->Response->ResponseStatus->Description . "\n";
//
//            //save soap request and response to file
//            $fw = fopen($outputFileName, 'w');
//            fwrite($fw, "Request: \n" . $client->__getLastRequest() . "\n");
//            fwrite($fw, "Response: \n" . $client->__getLastResponse() . "\n");
//            fclose($fw);
//        } catch (Exception $ex) {
//            print_r($ex);
//        }
//    }
}
