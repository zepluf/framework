<?php
/**
 * Created by Rubikin Team.
 * Date: 3/4/13
 * Time: 5:41 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Zepluf\Bundle\StoreBundle\Component\Cart\StorageHandler;

use Zepluf\Bundle\StoreBundle\Component\Product\ProductCollection;

class SessionStorageHandler implements StorageHandlerInterface
{
    protected $storage;
    protected $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    public function retrieve()
    {
        return $this->session->get('productCollection');
        // TODO: Implement get() method.
    }

    public function save(ProductCollection $productCollection)
    {

        //TODO: remove session start
        $this->session->set('productCollection', $productCollection);
    }
}