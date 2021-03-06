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

interface PaymentMethodInterface
{
    public function isAvailable();

    public function checkCondition();

    public function renderSelection();

    public function renderForm();

    public function renderSubmit();

    public function validation();

    public function process();
}
