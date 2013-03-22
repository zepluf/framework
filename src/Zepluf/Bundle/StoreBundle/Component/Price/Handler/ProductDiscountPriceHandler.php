<?php
/**
 * Created by Rubikin Team.
 * Date: 3/15/13
 * Time: 11:56 AM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Price\Handler;

use Zepluf\Bundle\StoreBundle\Component\Product\ProductComponent;
use Zepluf\Bundle\StoreBundle\Entity\PriceComponent;
use Zepluf\Bundle\StoreBundle\Entity\Product;
/**
 * Basic discount schemes to be implemented here
 */
class ProductDiscountPriceHandler implements PriceHandlerInterface, ProductPriceHandlerInterface
{
    protected $productComponent;

    public function __construct(ProductComponent $productComponent)
    {
        $this->productComponent = $productComponent;
    }

    public function getCode()
    {
        return 'product_discount';
    }

    public function getTag()
    {
        return 'product_global';
    }

    public function getPrice($currentPrice, PriceComponent $priceComponent, Product $product)
    {
        // discount by category
        if(is_array($categorySettings = $priceComponent->getSetting('category'))) {
            foreach ($categorySettings['categoryIds'] as $categoryId) {
                if ($this->productComponent->setProduct($product)->isChildOf($categoryId)) {
                    if($categorySettings['type'] == 1) {
                        return $currentPrice * (100 - $priceComponent->getValue()) / 100;
                    }
                }
            }
        }
    }
}
