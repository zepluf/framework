<?php
/**
 * Created by Rubikin Team.
 * Date: 3/18/13
 * Time: 3:21 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Shipment\Carrier;

use Symfony\Component\Yaml\Parser;

abstract class ShippingCarrierAbstract
{
    protected $code;

    public function getCode()
    {
        return $this->code;
    }

    public function getInfo()
    {
        return $this->getConfig('info');
    }

    public function isAvailable()
    {
        return true;
    }

    public function getConfig($param)
    {
        $parser = new Parser();
        $value = $parser->parse(file_get_contents(__DIR__ . '/config/' . $this->getCode() . '.yml'));

        if (isset($value[$param])) {
            return $value[$param];
        } else {
            return false;
        }
    }
}
