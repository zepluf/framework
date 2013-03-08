<?php
/**
 * Created by Rubikin Team.
 * Date: 3/8/13
 * Time: 3:18 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Shipping
{
    protected $entityManager;

    protected $order;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
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
}
