<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 9/30/12
 * Time: 4:31 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF
 */

namespace Zepluf\Bundle\StoreBundle\Component\Payment\Method;

/**
*
*/
class Cheque extends PaymentMethodAbstract implements PaymentMethodInterface
{
    /**
     * @var [type]
     */
    protected $settings;

    function __construct()
    {
        $this->settings = $this->getSettings();
    }

    /**
     * get current settings from this payment method
     *
     * @return array
     */
    public function getSettings()
    {
        /**
         * @todo get current payment method settings from storage handler
         */
        return array(
            'code' => 'cheque',
            'status' => 1,
            'sort_order' => 10
        );
    }

    /**
     * check current payment method is active or inactive
     *
     * @return boolean
     */
    public function isAvailable()
    {
        if (isset($this->settings['status']) && $this->settings['status']) {
            return true;
        } else {
            return false;
        }
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