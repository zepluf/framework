<?php
/**
 * Created by Rubikin Team.
 * Date: 3/7/13
 * Time: 7:45 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Order;

class OrderType
{
    /**
     * purchase order is an order that is used to restock the inventory
     * the buyer is probably the store itself
     */
    const PURCHASE_ORDER = 1;

    /**
     * a sales order is an order that
     * the buyer is probably the store's customer
     */
    const ORDER_TYPE = 2;
}
