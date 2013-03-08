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
use Zepluf\Bundle\StoreBundle\Entity\OrderItem;

class Order
{
    protected $entityManager;

    protected $order;

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function retrieve()
    {

    }

    public function create(ProductCollection $productCollection, $type = \OrderType::ORDER_TYPE)
    {
        $this->order = new OrderEntity();

        // sets the order type
        $this->order->setType($type);

        // set the order timestamp
        $this->order->setOrderDate(new \DateTime());

        // set the entry timestamp
        $this->order->setEntryDate(new \DateTime());

        // persists the order
        $this->entityManager->persist($this->order);
        $this->entityManager->flush();

        // add order contact mechanism

        // add order role

        // insert new order item
        $this->addItems($productCollection);
    }

    public function addItems(ProductCollection $productCollection)
    {
        if (false !== ($products = $productCollection->get())) {
            foreach ($products as $key => $product) {
                $orderItem = new OrderItem();

                $productEntity = $this->entityManager->find('Product', $product['id']);

                // set price
                $orderItem->setUnitPrice($productEntity->getPrice($product['features']));

                // set quantity
                $orderItem->setQuantity($product['quantity']);

                // set name (description)
                $orderItem->setItemDescription($productEntity->getName());

                // set order
                $orderItem->setOrder($this->order);
            }
        }
    }

    public function addInvoice()
    {

    }
}
