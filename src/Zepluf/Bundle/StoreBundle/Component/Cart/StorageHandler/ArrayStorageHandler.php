<?php
/**
 * Created by Rubikin Team.
 * Date: 3/5/13
 * Time: 3:25 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Cart\StorageHandler;

use Zepluf\Bundle\StoreBundle\Component\Product\ProductCollection;

class ArrayStorageHandler implements StorageHandlerInterface
{
    protected $data;

    public function save(ProductCollection $productCollection)
    {
        $this->data = $productCollection;
    }

    public function retrieve()
    {
        return $this->data;
    }
}
