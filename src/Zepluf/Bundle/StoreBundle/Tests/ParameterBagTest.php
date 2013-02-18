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

namespace Zepluf\Bundle\StoreBundle\Tests;

use Zepluf\Bundle\StoreBundle\ParameterBag;

class ParameterBagTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp(){
        $this->object = new ParameterBag();
    }

    public function testSet(){

        // setting simple key/value
        $this->object->set('key', 'value');
        $this->assertEquals($this->object->get('key'), 'value');

        // testing scalar
        $this->object->set('key1.key2', 'value');
        $this->assertEquals($this->object->get('key1'), array('key2' => 'value'));

        // test no merge
        $this->object->set('key1', array('key3' => 'value'));
        $this->assertEquals($this->object->get('key1'), array('key3' => 'value'));

        // test with merge
        $this->object->set('key1', array('key4' => 'value'), true);
        $this->assertEquals($this->object->get('key1'), array('key3' => 'value', 'key4' => 'value'));
    }

    public function testRemove(){

        $this->object->set('key', 'value');
        $this->object->remove('key');

        $this->assertEquals($this->object->get('key', 'default'), 'default');
    }

    public function testHas(){

        // test simple key/value
        $this->object->set('key', 'value');
        $this->assertTrue($this->object->has('key'));
        $this->assertFalse($this->object->has('key1'));

        // testing scallar
        $this->object->set('key1.key2', 'value');
        $this->assertTrue($this->object->has('key1'));
        $this->assertTrue($this->object->has('key1.key2'));
    }
}