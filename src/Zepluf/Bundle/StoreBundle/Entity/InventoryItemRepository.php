<?php
/**
 * Created by Rubikin Team.
 * Date: 3/19/13
 * Time: 4:21 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Entity;

/**
 *
 */
class InventoryItemRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByFeatureValuesIds($productId, $featureValueIds = '', $inventoryItemStatusType = 1)
    {
        if(empty($featureValueIds)) {
            $inventory = $this->_em->createQuery(
                'SELECT i.quantityOnhand, length(i.featureValueIds) fvl FROM Zepluf\Bundle\StoreBundle\Entity\InventoryItem i
                 WHERE i.product = :productId AND i.inventoryItemStatusType = :inventoryItemStatusType
                 ORDER BY fvl DESC')
                ->setParameters(array('productId' => $productId, 'inventoryItemStatusType' => $inventoryItemStatusType))->getOneOrNullResult();
        }
        else {
            $inventory = $this->_em->createQuery(
                'SELECT i.quantityOnhand, length(i.featureValueIds) fvl FROM Zepluf\Bundle\StoreBundle\Entity\InventoryItem i
                 WHERE i.product = :productId AND i.inventoryItemStatusType = :inventoryItemStatusType AND i.featureValueIds LIKE :featureValueIds
                 ORDER BY fvl DESC')
                ->setParameters(array('productId' => $productId, 'inventoryItemStatusType' => $inventoryItemStatusType, 'featureValueIds' => $featureValueIds . '%'))->getOneOrNullResult();
        }
        return $inventory;
    }
}
