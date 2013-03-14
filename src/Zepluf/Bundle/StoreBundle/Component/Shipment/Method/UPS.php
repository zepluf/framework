<?php
/**
 * Created by Rubikin Team.
 * Date: 3/13/13
 * Time: 3:36 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Zepluf\Bundle\StoreBundle\Component\Shipment\Carrier;

class UPS implements ShippingMethodInterface
{
    protected $code = 'ups';

    public function getInfo()
    {
        // TODO: Implement getInfo() method.
    }

    public function isAvailable()
    {
        // TODO: Implement isAvailable() method.
    }

    public function checkCondition()
    {
        // TODO: Implement checkCondition() method.
    }

    public function validateData()
    {
        // TODO: Implement validateData() method.
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

    public function getAllowMethods()
    {
        // TODO: Implement getAllowMethods() method.
    }

    public function getRate()
    {
        // TODO: Implement getRate() method.
    }

}
