<?php
/**
 * Created by Rubikin Team.
 * Date: 3/20/13
 * Time: 6:13 AM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Inventory;

use Zepluf\Bundle\StoreBundle\Component\Inventory\Strategy\InventoryStrategyInterface;
use Zepluf\Bundle\StoreBundle\Entity\InventoryAdjustment;
use Zepluf\Bundle\StoreBundle\Entity\InventoryItem;

class InventoryComponent
{
    protected $entityManager;

    protected $doctrine;
    
    protected $inventoryStrategy;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $doctrine->getEntityManager();
    }

    public function setInventoryStrategy(InventoryStrategyInterface $inventoryStrategy)
    {
        $this->inventoryStrategy = $inventoryStrategy;
    }

    /**
     * Get the product quantity onhand given the id and the feature combination
     * @param $productId
     * @param array $featureValueIds
     * @return int
     */
    public function getProductQuantity($productId, $featureValueIds = array(), $inventoryItemStatusType = 1)
    {
        $featureValueIds = $this->getFeatureValueIdsString($featureValueIds);

        // get the inventory for the specific set of featureValues
        if (NULL == ($inventory = $this->doctrine->getRepository('StoreBundle:InventoryItem')->findByFeatureValuesIds($productId, $featureValueIds, $inventoryItemStatusType))) {
            return 0;
        } else {
            return $inventory['quantityOnhand'];
        }
    }

    /**
     * Get the product inventory
     *
     * TODO: allow store owners to use different strategy to select
     * the inventory item they want
     */
    public function getInventoryAdjustments($productId, $featureValueIds, $quantity, $inventoryItemStatusType = 1)
    {
        $featureValueIds = $this->getFeatureValueIdsString($featureValueIds);

        return $this->inventoryStrategy->getInventoryAdjustments($this->entityManager, $productId, $featureValueIds, $quantity, $inventoryItemStatusType);
    }

    /**
     * @param array $inventories
     */
    public function adjustInventory($inventoryAdjustments)
    {
        // begin a transaction
        $this->entityManager->getConnection()->beginTransaction(); // suspend auto-commit
        try {
            foreach ($inventoryAdjustments as $inventoryAdjustment)
            {
                // update inventory
                $inventoryAdjustment['inventoryItem']->setQuantityOnhand($inventoryAdjustment['inventoryItem']->setQuantityOnhand() - $inventoryAdjustment['quantity']);
                $this->entityManager->persist($inventoryAdjustment['inventoryItem']);

                // update adjustment table
                $this->entityManager->persist($inventoryAdjustment);

                $inventoryAdjustmentEntity = new InventoryAdjustment();

                $inventoryAdjustmentEntity->setDate(new \DateTime());

                $inventoryAdjustmentEntity->setInventoryItem($inventoryAdjustment['inventoryItem']);

                $inventoryAdjustmentEntity->setQuantity($inventoryAdjustment['quantity']);

                // $inventoryAdjustmentEntity->setPicklistItem($inventorieAdjustment['picklistItem']);

                // $inventoryAdjustmentEntity->setShipmentItem($inventoryAdjustment['shipmentItem']);

                $this->entityManager->persist($inventoryAdjustmentEntity);

            }

            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();

            // dispatch an event

        } catch (Exception $e) {
            $this->entityManager->getConnection()->rollback();
            $this->entityManager->close();
            throw $e;
        }
    }

    public function generatePicklist()
    {

    }

    private function getFeatureValueIdsString($featureValueIds)
    {
        if (is_array($featureValueIds)) {
            // if the features array is not empty, we first sort it
            if (!empty($featureValueIds)) {
                asort($featureValueIds);
            }

            $featureValueIds = implode(',', $featureValueIds);
        }

        return $featureValueIds;
    }
}
