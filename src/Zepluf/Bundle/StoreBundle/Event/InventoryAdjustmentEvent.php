<?php
/**
 * Created by Rubikin Team.
 * Date: 3/20/13
 * Time: 5:43 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class InventoryAdjustmentEvent
 * @package Zepluf\Bundle\StoreBundle\Event
 */
class InventoryAdjustmentEvent extends Event
{
    private $shipmentId = 0;

    /**
     * Constructor
     * @param int $shipmentId
     */
    public function __construct($shipmentId = 0)
    {
        $this->shipmentId = $shipmentId;
    }

    /**
     * @param $shipmentId
     * @return InventoryAdjustmentEvent
     */
    public function setShipmentId($shipmentId)
    {
        $this->shipmentId = $shipmentId;

        return $this;
    }

}