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

class CartFactory
{
    /**
     *  Logic code to get the suitable storage handler
     */
    public function getHandler(ArrayStorageHandler $arrayStorageHandler)
    {
        $cart = new Cart();

        //Logical code to select storage handler

        //TODO: Change default array storage handler
        $cart->setStorageHandler($arrayStorageHandler);
        return $cart;
    }
}
