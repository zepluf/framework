<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 10/15/12
 * Time: 11:53 AM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF framework
 */

namespace plugins\riCore\tests;

use plugins\riCore\Object;

class ObjectTest extends \UnitTestCase
{
    public function testSet(){
        $object = new Object();
        $object->set('key', 'value');
        $this->assertEqual($object->get('key'), 'value');
    }

    public function testGet(){
        $object = new Object();
        $this->assertEqual($object->get('key', 'default'), 'default');
    }
}
