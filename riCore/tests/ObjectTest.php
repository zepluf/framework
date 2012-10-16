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
    protected $object;

    public function setUp(){
        $this->object = new Object();
    }
    public function testSet(){
        $this->object->set('key', 'value');
        $this->assertEqual($this->object->get('key'), 'value');
    }

    public function testGet(){
        $this->assertEqual($this->object->get('key', 'default'), 'default');
    }

    public function testMagicSet(){
        $this->object->key = 'value';
        $this->assertEqual($this->object->get('key'), 'value');
    }

    public function testMagicSet2(){
        $this->object->setKey('value');
        $this->assertEqual($this->object->get('key'), 'value');
    }

    public function testMagicGet(){
        $this->object->set('key', 'value');
        $this->assertEqual($this->object->key, 'value');
    }

    public function testMagicGet2(){
        $this->object->set('key', 'value');
        $this->assertEqual($this->object->getKey(), 'value');
    }

    public function testIsset(){
        $this->object->set('key', 'value');
        $this->assertTrue(isset($this->object->key));
        $this->assertFalse(isset($this->object->key2));
    }

    public function testHas(){
        $this->object->set('key', 'value');
        $this->assertTrue($this->object->has('key'));
        $this->assertFalse($this->object->has('key2'));
    }

    public function testSetArray(){
        $array = array('key1' => 'value1', 'key2' => 'value2');
        $this->object->setArray($array);
        $this->assertEqual($this->object->get('key1'), 'value1');
        $this->assertEqual($this->object->get('key2'), 'value2');
    }

    public function testGetArray(){
        $array = array('key1' => 'value1', 'key2' => 'value2');
        $this->object->setArray($array);
        $this->assertIdentical($this->object->getArray(), $array);
    }

    public function testSerialize(){
        $array = array('key1' => 'value1', 'key2' => 'value2');
        $this->object->setArray($array);

        $this->assertEqual($this->object->serialize(), 'a:2:{s:4:"key1";s:13:"s:6:"value1";";s:4:"key2";s:13:"s:6:"value2";";}');
    }

    public function testUnserialize(){
        $array = array('key1' => 'value1', 'key2' => 'value2');
        $this->object->unserialize('a:2:{s:4:"key1";s:13:"s:6:"value1";";s:4:"key2";s:13:"s:6:"value2";";}');

        $this->assertIdentical($this->object->getArray(), $array);
    }
}
