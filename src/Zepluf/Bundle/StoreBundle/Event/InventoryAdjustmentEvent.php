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

class InventoryAdjustmentEvent extends Event
{
    private $productId;
    private $features = array();
    private $quantity;
    private $shipmentItemId = 0;
    private $picklistItemId = 0;

    public function __construct($productId, $features = array(), $quantity, $shipmentItemId = 0, $picklistItemId = 0)
    {
        $this->productId = $productId;
        $this->features = $features;
        $this->quantity = $quantity;
        $this->shipmentItemId = $shipmentItemId;
        $this->picklistItemId = $picklistItemId;
    }

    public function setFeatures($features)
    {
        $this->features = $features;

        return $this;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function setShipmentItemId($shipmentItemId)
    {
        $this->shipmentItemId = $shipmentItemId;

        return $this;
    }

    public function setPicklistItemId($picklistItemId)
    {
        $this->picklistItemId = $picklistItemId;

        return $this;
    }
}