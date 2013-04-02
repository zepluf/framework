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
    protected $name = 'United Parcel Service';

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
            $option['RequestOption'] = 'Rate';

            $service['Code'] = $request->getMethod();
            $service['Description'] = 'Service Code';
            $shipment['Service'] = $service;
        } else {
            $option['RequestOption'] = 'Shop';
        }
        $r['Request'] = $option;

        $pickupType['Code'] = '01';
        $pickupType['Description'] = 'Daily Pickup';
        $r['PickupType'] = $pickupType;

//        $customerclassification['Code'] = '01';
//        $customerclassification['Description'] = 'Classfication';
//        $request['CustomerClassification'] = $customerclassification;

        //  Shipper Information
        $shipper['Name'] = 'Imani Carr';
        $shipper['ShipperNumber'] = '222006';
        $address['AddressLine'] = array
        (
            'Southam Rd',
            '4 Case Cour',
            'Apt 3B'
        );
        $address['City'] = 'Timonium';
        $address['StateProvinceCode'] = 'MD';
        $address['PostalCode'] = '21093';
        $address['CountryCode'] = 'US';
        $shipper['Address'] = $address;
        $shipment['Shipper'] = $shipper;

        //  Origination Information
        $addressFrom['CountryCode'] = $request->getOriginationCountry() ? $request->getOriginationCountry() : '';
        $addressFrom['PostalCode'] = $request->getOriginationPostal() ? $addressFrom['PostalCode'] = $request->getOriginationPostal() : '';
        $addressFrom['City'] = $request->getOriginationCity() ? $request->getOriginationCity() : '';
        $addressFrom['StateProvinceCode'] = $request->getOriginationStateProvince() ? $request->getOriginationStateProvince() : '';
        $shipFrom['Address'] = $addressFrom;
        $shipment['ShipFrom'] = $shipFrom;

        //  Destination Information
        $addressTo['CountryCode'] = $request->getDestinationCountry() ? $request->getDestinationCountry() : '';
        $addressTo['PostalCode'] = $request->getDestinationPostal() ? $request->getDestinationPostal() : '';
        $addressTo['City'] = $request->getDestinationCity() ? $request->getDestinationCity() : '';
        $addressTo['StateProvinceCode'] = $request->getDestinationStateProvince() ? $request->getDestinationStateProvince() : '';
        $addressTo['ResidentialAddressIndicator'] = '';
        $shiptTo['Address'] = $addressTo;
        $shipment['ShipTo'] = $shiptTo;

        //  Package Information
        if ($request->getPackageContainer()) {
            $packaging['Code'] = $this->convertValue('container', $request->getPackageContainer());
            $packaging['Description'] = 'Rate';
        } else {
            $packaging['Code'] = $this->convertValue('container', $this->getConfig('container'));
            $packaging['Description'] = 'Rate';
        }
        $package['PackagingType'] = $packaging;

        if ($request->getPackageUOM()) {
            $pUnit['Code'] = $request->getPackageUOM();
        } else {
            $pUnit['Code'] = $this->getConfig('UOM');
        }

        if ($request->getPackageWeight()) {
            $packageWeight['UnitOfMeasurement'] = $pUnit;
            $packageWeight['Weight'] = $request->getPackageWeight();
        }

        $package['PackageWeight'] = $packageWeight;

        $shipment['Package'] = $package;
        $shipment['ShipmentServiceOptions'] = '';
        $shipment['LargePackageIndicator'] = '';
        $r['Shipment'] = $shipment;

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

        if ($request['Request']['RequestOption'] === 'Shop') {
            // Service code is not relevant when we're asking ALL possible services' rates
            $serviceCode = null;
        } else {
            $serviceCode = $request['Shipment']['Service']['Code'];
        }
//var_dump($request);
//        die();
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
                <RequestOption>{$request['Request']['RequestOption']}</RequestOption>
            </Request>
            <PickupType>
                <Code>{$request['PickupType']['Code']}</Code>
                <Description>{$request['PickupType']['Description']}</Description>
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
                      <PostalCode>{$request['Shipment']['ShipFrom']['Address']['PostalCode']}</PostalCode>
                        <CountryCode>{$request['Shipment']['ShipFrom']['Address']['CountryCode']}</CountryCode>
                        <StateProvinceCode>{$request['Shipment']['ShipFrom']['Address']['StateProvinceCode']}</StateProvinceCode>
                        <City>{$request['Shipment']['ShipFrom']['Address']['City']}</City>
                    </Address>
                </Shipper>
                <ShipTo>
                    <Address>
                        <PostalCode>{$request['Shipment']['ShipTo']['Address']['PostalCode']}</PostalCode>
                        <CountryCode>{$request['Shipment']['ShipTo']['Address']['CountryCode']}</CountryCode>
                        <StateProvinceCode>{$request['Shipment']['ShipTo']['Address']['StateProvinceCode']}</StateProvinceCode>
                        <City>{$request['Shipment']['ShipTo']['Address']['City']}</City>
                    </Address>
                </ShipTo>

                <ShipFrom>
                    <Address>
                        <PostalCode>{$request['Shipment']['ShipFrom']['Address']['PostalCode']}</PostalCode>
                        <CountryCode>{$request['Shipment']['ShipFrom']['Address']['CountryCode']}</CountryCode>
                        <StateProvinceCode>{$request['Shipment']['ShipFrom']['Address']['StateProvinceCode']}</StateProvinceCode>
                        <City>{$request['Shipment']['ShipFrom']['Address']['City']}</City>
    			    </Address>
                </ShipFrom>
_XMLRequest_;
        if ($serviceCode !== null) {
            $xmlRequest .=
                "<Service>" .
                    "<Code>{$serviceCode}</Code>" .
                    "<Description>{$request['Shipment']['Service']['Description']}</Description>" .
                    "</Service>";
        }

        $xmlRequest .=
            <<<_XMLRequest_
                <Package>
                    <PackagingType>
                        <Code>{$request['Shipment']['Package']['PackagingType']['Code']}</Code>
                    </PackagingType>
                    <PackageWeight>
                        <UnitOfMeasurement>
                            <Code>{$request['Shipment']['Package']['PackageWeight']['UnitOfMeasurement']['Code']}</Code>
                        </UnitOfMeasurement>
                        <Weight>{$request['Shipment']['Package']['PackageWeight']['Weight']}</Weight>
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

    /**
     * Parse a XML Response by UPS server
     * @param \SimpleXMLElement $response
     * @return ShippingQuote on success or false on failure
     */
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
                $serviceName = $this->convertValue('service', $code);

                if ($serviceName === false) {
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

                $costArr[$code] = array('serviceName' => $serviceName, 'cost' => $cost, 'currencyCode' => $currency);
            }

            $quote = new ShippingQuote($this->name);
            $quote->setQuotes($costArr);

            return $quote;
        } else {
            return false;
        }
    }

    public function getSoapQuotes($request)
    {
        $wsdl = __DIR__ . "/UPS/RateWS.wsdl";
        $operation = "ProcessRate";
        $endpointUrl = 'https://wwwcie.ups.com/webservices/Rate';
        $outputFileName = __DIR__ . "/UPS/XOLTResult.xml";

        // Authentication
        $accessLicenseNumber = $this->getConfig('access_license_number');
        $userId = $this->getConfig('user_id');
        $password = $this->getConfig('password');

        try {
            $mode = array
            (
                'soap_version' => 'SOAP_1_1', // use soap 1.1 client
                'trace' => 1
            );
            // initialize soap client
            $client = new \SoapClient($wsdl, $mode);
            //set endpoint url
            $client->__setLocation($endpointUrl);

            //create soap header
            $usernameToken['Username'] = $userId;
            $usernameToken['Password'] = $password;
            $serviceAccessLicense['AccessLicenseNumber'] = $accessLicenseNumber;
            $upss['UsernameToken'] = $usernameToken;
            $upss['ServiceAccessToken'] = $serviceAccessLicense;

            $header = new \SoapHeader('http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0', 'UPSSecurity', $upss);
            $client->__setSoapHeaders($header);

            //get response
            $resp = $client->__soapCall($operation, array($request));

            var_dump($resp->RatedShipment);

            //get status
            echo "Response Status: " . $resp->Response->ResponseStatus->Description . "\n";

            //save soap request and response to file
            $fw = fopen($outputFileName, 'w');
            fwrite($fw, "Request: \n" . $client->__getLastRequest() . "\n");
            fwrite($fw, "Response: \n" . $client->__getLastResponse() . "\n");
            fclose($fw);
        } catch (\Exception $ex) {
            echo $ex;
        }
    }
}