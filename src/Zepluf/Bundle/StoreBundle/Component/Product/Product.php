<?php
/**
 * Created by Rubikin Team.
 * Date: 3/4/13
 * Time: 5:41 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Product;

use Zepluf\Bundle\StoreBundle\Entity\Product as ProductEntity;

class Product
{
    private $product;

    public function setProduct(ProductEntity $product)
    {
        $this->product = $product;
    }

    public function getPrice($features = array())
    {
        // loop through the base price component
        $this->product->getPriceComponent();

        // get the total of features price

        // loop through the additional price component
    }
}
