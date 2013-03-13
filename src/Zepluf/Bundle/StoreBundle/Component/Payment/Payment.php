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

use Zepluf\Bundle\StoreBundle\Component\Payment\StorageHandler\PaymentStorageHandlerInterface;

/**
 *
 */
class Payment implements PaymentInterface
{
    /**
     * @var [type]
     */
    protected $paymentMethod;
    protected $storageHandler;

    /**
     * set payment storate handler
     *
     * @param PaymentStorageHandlerInterface $storateHandler
     */
    public function setStorageHandler(PaymentStorageHandlerInterface $storageHandler)
    {
        $this->storageHandler = $storageHandler;
    }

    /**
     * check payment is available
     *
     * @return boolean
     */
    public function isAvailable()
    {
        // return $this->arrayStorageHandler->isAvailable();
    }

    public function checkCondition()
    {
        // return $this->arrayStorageHandler->checkCondition();
    }

    public function renderSelection()
    {
        // TODO: Implement renderSelection() method.
    }

    public function renderForm()
    {
        // TODO: Implement renderForm() method.
    }

    public function renderSubmit()
    {
        // TODO: Implement renderSubmit() method.
    }

    public function validation()
    {
        // TODO: Implement validation() method.
    }

    public function process()
    {
        // TODO: Implement process() method.
    }

}