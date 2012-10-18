<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 10/17/12
 * Time: 9:03 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF framework
 */

namespace plugins\riCore\tests;

use plugins\riCore\ParameterBag;

class ParameterBagTest extends \UnitTestCase
{
    protected $object;

    public function setUp(){
        $this->object = new ParameterBag();
    }
}

