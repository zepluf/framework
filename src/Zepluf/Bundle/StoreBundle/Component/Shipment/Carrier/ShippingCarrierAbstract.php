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
    protected $config;

    public function getCode()
    {
        return $this->code;
    }

    function __construct()
    {
        $yamlFile = __DIR__ . '/config/' . $this->getCode() . '.yml';

        if (file_exists($yamlFile)) {
            $yaml = new Parser();
            $this->config = $yaml->parse(file_get_contents($yamlFile));
        }
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
        if (null === $param) {
            return $this->config;
        } else if (isset($this->config[$param])) {
            return $this->config[$param];
        } else {
            return false;
        }
    }
}
