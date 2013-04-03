<?php
/**
 * Created by Rubikin Team.
 * Date: 3/21/13
 * Time: 9:32 AM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Shipment;


class ShippingQuote
{
    protected $carrier;
    protected $quotes = array();

    function __construct($carrier)
    {
        $this->carrier = $carrier;
    }

    public function setCarrier($carrier)
    {
        $this->carrier = $carrier;
        return $this;
    }

    public function getCarrier()
    {
        return $this->carrier;
    }

    public function setQuotes($quotes)
    {
        $this->quotes = $quotes;
        return $this;
    }

    public function getQuotes()
    {
        return $this->quotes;
    }


}