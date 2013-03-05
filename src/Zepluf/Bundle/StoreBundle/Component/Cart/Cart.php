<?php
/**
 * Created by Rubikin Team.
 * Date: 3/5/13
 * Time: 3:23 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Cart
{
    protected $storageHandler;

    public function __construct()
    {
        // get from storageHandler
    }

    public function add()
    {
        // check condition

        $this->storageHandler->set();
    }

    public function setStorageHandler($storageHandler)
    {
        $this->storageHandler = $storageHandler;
    }
}
