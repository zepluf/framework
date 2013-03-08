<?php
/**
 * Created by Rubikin Team.
 * Date: 3/7/13
 * Time: 7:00 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Order;

use Zepluf\Bundle\StoreBundle\Component\Product\ProductCollection;
use Zepluf\Bundle\StoreBundle\Entity\Order as OrderEntity;
use Doctrine\ORM\EntityManager;

class Order
{
    protected $entityManager;

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(ProductCollection $productCollection, $type = \OrderType::ORDER_TYPE)
    {
        $order = new OrderEntity();

        // sets the order type
        $order->setType($type);

        // set the order timestamp
        $order->setOrderDate(new \DateTime());

        // set the entry timestamp
        $order->setEntryDate(new \DateTime());

        // persists the order
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        // insert new order item

    }
}
