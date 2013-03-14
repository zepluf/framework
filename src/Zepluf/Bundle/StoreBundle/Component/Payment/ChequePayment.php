<?php
/**
 * Created by Rubikin Team.
 * Date: 3/4/13
 * Time: 5:41 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Payment;


/**
*
*/
class ChequePayment implements PaymentInterface
{
    /**
     * @var [type]
     */
    protected $settings;

    /**
     * @var [type]
     */
    protected $storateHandler;

    function __construct()
    {
        # code
    }

    /**
     * set payment storate handler
     *
     * @param PaymentStorageHandlerInterface $storateHandler
     */
    public function setStorateHandler(PaymentStorageHandlerInterface $storateHandler)
    {
        $this->storateHandler = $storateHandler;
    }

    /**
     * check current payment method is active or inactive
     *
     * @return boolean
     */
    public function isAvailable()
    {
        return $this->settings['status'];
    }

    /**
     * check all current payment method conditions are passed
     *
     * @return boolean
     */
    public function checkCondition()
    {
        // TODO:
        // get and check all conditions for this payment method are passed
        // with contact mechanism, order items, shipping method
        return true;
    }

    /**
     * [renderSelection description]
     *
     * @return [type] [description]
     */
    public function renderSelection()
    {

    }

    /**
     * [renderSelection description]
     *
     * @return [type] [description]
     */
    public function renderForm()
    {
        return null;
    }

    /**
     * [renderSelection description]
     *
     * @return [type] [description]
     */
    public function renderSubmit()
    {

    }

    /**
     * validation form data
     *
     * @return boolean
     */
    public function validation()
    {
        return true;
    }

    public function process()
    {

    }
}