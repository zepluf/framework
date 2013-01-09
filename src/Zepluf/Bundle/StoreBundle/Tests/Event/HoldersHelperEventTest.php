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

namespace Zepluf\Bundle\StoreBundle\Tests;

use \Zepluf\Bundle\StoreBundle\Event\HoldersHelperEvent;

class HoldersHelperEventTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        $this->object = new HoldersHelperEvent("test");
    }

    public function testConst()
    {
        $holder = 'test';
        $this->assertEquals($holder, $this->object->getHolder());
    }

    public function testGetSet()
    {
        $this->object->setHolder('test2');
        $this->assertEquals('test2', $this->object->getHolder());
    }

    public function tearDown()
    {
        unset($this->object);
    }
}