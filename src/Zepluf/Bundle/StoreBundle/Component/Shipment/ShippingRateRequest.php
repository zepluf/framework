<?php
/**
 * Created by Rubikin Team.
 * Date: 3/21/13
 * Time: 5:17 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Shipment;


class ShippingRateRequest
{
    protected $carrier;
    protected $method;

    protected $originationCity;
    protected $originationStateProvince;
    protected $originationZip;
    protected $originationCountry;

    protected $destinationCity;
    protected $destinationStateProvince;
    protected $destinationZip;
    protected $destinationCountry;

    protected $packageValue;
    protected $packageWeight;
    protected $packageHeight;
    protected $packageWidth;
    protected $packageLength;

    public function setCarrier($carrier)
    {
        $this->carrier = $carrier;

        return $this;
    }

    public function getCarrier()
    {
        return $this->carrier;
    }

    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }


    public function setDestinationCity($destinationCity)
    {
        $this->destinationCity = $destinationCity;

        return $this;
    }

    public function getDestinationCity()
    {
        return $this->destinationCity;
    }

    public function setDestinationCountry($destinationCountry)
    {
        $this->destinationCountry = $destinationCountry;

        return $this;
    }

    public function getDestinationCountry()
    {
        return $this->destinationCountry;
    }

    public function setDestinationStateProvince($destinationStateProvince)
    {
        $this->destinationStateProvince = $destinationStateProvince;

        return $this;
    }

    public function getDestinationStateProvince()
    {
        return $this->destinationStateProvince;
    }

    public function setDestinationZip($destinationZip)
    {
        $this->destinationZip = $destinationZip;

        return $this;
    }

    public function getDestinationZip()
    {
        return $this->destinationZip;
    }



    public function setOriginationCity($originationCity)
    {
        $this->originationCity = $originationCity;

        return $this;
    }

    public function getOriginationCity()
    {
        return $this->originationCity;
    }

    public function setOriginationCountry($originationCountry)
    {
        $this->originationCountry = $originationCountry;

        return $this;
    }

    public function getOriginationCountry()
    {
        return $this->originationCountry;
    }

    public function setOriginationStateProvince($originationStateProvince)
    {
        $this->originationStateProvince = $originationStateProvince;

        return $this;
    }

    public function getOriginationStateProvince()
    {
        return $this->originationStateProvince;
    }

    public function setOriginationZip($originationZip)
    {
        $this->originationZip = $originationZip;

        return $this;
    }

    public function getOriginationZip()
    {
        return $this->originationZip;
    }

    public function setPackageHeight($packageHeight)
    {
        $this->packageHeight = $packageHeight;

        return $this;
    }

    public function getPackageHeight()
    {
        return $this->packageHeight;
    }

    public function setPackageLength($packageLength)
    {
        $this->packageLength = $packageLength;

        return $this;
    }

    public function getPackageLength()
    {
        return $this->packageLength;
    }

    public function setPackageValue($packageValue)
    {
        $this->packageValue = $packageValue;

        return $this;
    }

    public function getPackageValue()
    {
        return $this->packageValue;
    }

    public function setPackageWeight($packageWeight)
    {
        $this->packageWeight = $packageWeight;

        return $this;
    }

    public function getPackageWeight()
    {
        return $this->packageWeight;
    }

    public function setPackageWidth($packageWidth)
    {
        $this->packageWidth = $packageWidth;

        return $this;
    }

    public function getPackageWidth()
    {
        return $this->packageWidth;
    }
}