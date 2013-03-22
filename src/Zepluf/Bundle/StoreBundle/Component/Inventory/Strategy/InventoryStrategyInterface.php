<?php
/**
 * Created by Rubikin Team.
 * Date: 3/20/13
 * Time: 1:47 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Inventory\Strategy;


use Doctrine\ORM\EntityManager;
use Zepluf\Bundle\StoreBundle\Entity\Product;

interface InventoryStrategyInterface {

    /**
     * Get the inventories for the product with specific feature combination
     * It is possible that we will get an array of inventory if 1 single inventory item
     * does not satisfy the required quantity
     *
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param int $productId
     * @param string $featureValueIds
     * @param int $quantity
     * @param int $inventoryItemStatusType
     * @return array
     */
    public function getInventoryAdjustments(EntityManager $entityManager, $productId, $featureValueIds, $quantity, $inventoryItemStatusType);
}