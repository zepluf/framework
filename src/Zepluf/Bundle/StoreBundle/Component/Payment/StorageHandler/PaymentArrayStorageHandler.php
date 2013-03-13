<?php
/**
 * Created by Rubikin Team.
 * Date: 3/4/13
 * Time: 5:41 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Payment\StorageHandler;

/**
 * store payment method settings into array
 */
class PaymentArrayStorageHandler implements PaymentStorageHandlerInterface
{
    /**
     * @var current payment method settings
     */
    protected $settings;

    public function __construct()
    {
        /**
         * @todo get current payment method settings from this storage handler
         */
        $this->settings = array(
            'status' => 1,
            'sort_order' => 10
        );
    }

    /**
     * set current payment method settings
     *
     * @param  array  $settings current payment method settings
     *
     * @return void
     */
    public function set($settings = array())
    {
        $this->settings = $settings;
    }

    /**
     * get current payment method settings
     *
     * @return array
     */
    public function retrieve()
    {
        return $this->settings;
    }

    /**
     * save current payment method settings to this storage handler
     *
     * @return void
     */
    public function flush()
    {
        /**
         * @todo save current payment method settings to this storage handler
         */

        # code
    }
}