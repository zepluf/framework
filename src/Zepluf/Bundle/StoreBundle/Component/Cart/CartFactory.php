<?php
/**
 * Created by Rubikin Team.
 * Date: 3/4/13
 * Time: 5:41 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Cart;

use Zepluf\Bundle\StoreBundle\Component\Cart\StorageHandler\ArrayStorageHandler;
use Zepluf\Bundle\StoreBundle\Component\Cart\StorageHandler\SessionStorageHandler;

class CartFactory
{
    /**
     *  Logic code to get the suitable storage handler
     */
    public function get(ArrayStorageHandler $arrayStorageHandler, SessionStorageHandler $sessionStorageHandler)
    {
        $cart = new Cart();
        //Logical code to select storage handler

        //TODO: Change default array storage handler
        $cart->setStorageHandler($sessionStorageHandler);
        return $cart;
    }
}
