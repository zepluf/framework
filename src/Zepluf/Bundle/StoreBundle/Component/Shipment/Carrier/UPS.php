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

class UPS
    extends ShippingCarrierAbstract
    implements ShippingCarrierInterface
{
    protected $code = 'ups';

    protected $xmlGatewayUrl = 'https://www.ups.com/ups.app/xml/Rate';
    protected $cgiGatewayUrl = 'http://www.ups.com:80/using/services/rave/qcostcgi.cgi';

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

    public function getRates($request)
    {
        $result = $this->getQuotes($request);

        return $result;
    }

    /**
     * Build request, hit the UPS web service and return some
     * rate information.
     **/
    protected function getQuotes($request)
    {
        //TODO: What's request option?

        //AccessRequest
        $accessLicenseNumber = $this->getConfig('access_key');
        $userId = $this->getConfig('user_id');
        $password = $this->getConfig('password');
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
                <RequestOption>Rate</RequestOption>
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
        //TODO:Shipper Address?

        $xmlRequest .=
            <<<_XMLRequest_
                <ShipTo>
                    <Address>
                        <PostalCode>{$request['destZip']}</PostalCode>
                        <CountryCode>{$request['destCountry']}</CountryCode>
                        <ResidentialAddress>{$request['residential']}</ResidentialAddress>
                        <StateProvinceCode>{$request['destRegionCode']}</StateProvinceCode>
                    </Address>
                </ShipTo>

                <ShipFrom>
                    <Address>
                        <PostalCode>{$request['origZip']}</PostalCode>
                        <CountryCode>{$request['origCountry']}</CountryCode>
                        <StateProvinceCode>{$request['origRegionCode']}</StateProvinceCode>
    			    </Address>
                </ShipFrom>

                <Package>
                    <PackagingType>
                        <Code>{$request['container']}</Code>
                    </PackagingType>
                    <PackageWeight>
                        <UnitOfMeasurement><Code>{$request['unitOfMeasurement']}</Code></UnitOfMeasurement>
                        <Weight>{$request['weight']}</Weight>
                    </PackageWeight>
                </Package>
_XMLRequest_;
        if ($this->getConfig('negotiated')) {
            $xmlRequest .= "<RateInformation><NegotiatedRatesIndicator/></RateInformation>";
        }

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

    protected function parseXMLResponse($response)
    {
        //TODO: Parse data
        return $response;
    }
}
