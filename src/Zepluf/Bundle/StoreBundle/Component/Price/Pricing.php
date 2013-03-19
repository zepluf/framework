<?php
/**
 * Created by Rubikin Team.
 * Date: 3/13/13
 * Time: 5:18 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Price;

/**
 * This class is responsible for calculating price for anything that uses priceComponent
 */
class Pricing extends \Symfony\Component\DependencyInjection\ContainerAware
{
    /**
     * an array of handlers
     *
     * @var
     */
    protected $handlers;

    /**
     * Get the product price
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Product $product
     * @param array $features
     * @return float
     */
    public function getProductPrice(\Zepluf\Bundle\StoreBundle\Entity\Product $product, $features = array())
    {
        $productPrice = new Price();
        // loop through the base price component
        $productPrice = $this->getPrice($productPrice, $product->getPriceComponent());

        // get the total of features price
        foreach ($product->getProductFeatureApplication() as $productFeatureApplication) {
            $productPrice = $this->getPrice($productPrice, $productFeatureApplication->getPriceComponent());
        }

        // loop through the additional price component
        $productPrice = $this->getPrice($productPrice, $this->findTaggedHandlers('product_global'));

        return $productPrice;
    }

    /**
     * Get Product's Feature Price
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ProductFeatureApplication $productFeatureApplication
     * @return float
     */
    public function getProductFeatureApplicationPrice(\Zepluf\Bundle\StoreBundle\Entity\ProductFeatureApplication $productFeatureApplication)
    {
        return $this->getPrice(new Price(), $productFeatureApplication->getPriceComponent());
    }

    /**
     * Get Order Price
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Order $order
     * @return float
     */
    public function getOrderPrice(\Zepluf\Bundle\StoreBundle\Entity\Order $order)
    {
        return $this->getPrice(new Price(), $this->findTaggedHandlers('order_global'));
    }

    /**
     * Add handler
     *
     * @param \Zepluf\Bundle\StoreBundle\Component\Price\PriceHandlerInterface $handler
     */
    public function addHandler(\Zepluf\Bundle\StoreBundle\Component\Price\PriceHandlerInterface $handler)
    {
        $this->handlers[$handler->getCode()] = $handler;
    }

    /**
     * Return an array of handler with specific tag
     *
     * @param $tag
     * @return array
     */
    public function findTaggedHandlers($tag)
    {
        $tags = array();
        foreach ($this->handlers as $id => $handler) {
            if ($handler->getTag() == $tag) {
                $tags[$id] = $handler;
            }
        }

        return $tags;
    }

    /**
     * Loop through the list of priceComponents to get the price
     *
     * @param $price
     * @param $priceComponents
     * @return \Zepluf\Bundle\StoreBundle\Component\Price\Price
     */
    public function getPrice(\Zepluf\Bundle\StoreBundle\Component\Price\Price $price, $priceComponents)
    {
        foreach ($priceComponents as $priceComponent) {
            $handlerCode = $priceComponent->getHandler();
            if (isset($this->handlers[$handlerCode])) {
                $price->addComponent(
                    $this->handlers[$handlerCode]->getCode(),
                    $this->handlers[$handlerCode]->getTag(),
                    $priceComponent->getName(),
                    $this->handlers[$handlerCode]->getPrice($price->getTotal(), $priceComponent));
            }
        }

        return $price;
    }
}
