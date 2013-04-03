<?php
/**
 * Created by Rubikin Team.
 * Date: 3/25/13
 * Time: 4:26 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Shipment;


class ShipmentType
{
    /**
     * A CUSTOMER SHIPMENT defines shipments sent out to customers.
     * Type:    Outgoing shipment
     */
    const CUSTOMER_SHIPMENT = 10;

    /**
     * A PURCHASE RETURN defines shipments that were returned to the supplier.
     * Type:    Outgoing shipment
     */
    const PURCHASE_RETURN = 11;

    /**
     * A PURCHASE SHIPMENT is an incoming shipment of purchased items from a supplier.
     * Type:    Incoming shipment
     */
    const PURCHASE_SHIPMENT = 20;

    /**
     * A CUSTOMER RETURN is an incoming shipment from a customer that has returned the products bought from the enterprise.
     * Type:    Incoming shipment
     */
    const CUSTOMER_RETURN = 21;

    /**
     * A TRANSFER is a shipment from an internal organization to another internal organization (e.g., from department A to department B)
     */
    const TRANSFER = 30;

    /**
     * A DROP SHIPMENT is a shipment moves from an external organization to a different external organization.
     * Typically, a drop shipment is a mechanism for a distributor to ship products directly from its supplier to its customer.
     */
    const DROP_SHIPMENT = 40;

}