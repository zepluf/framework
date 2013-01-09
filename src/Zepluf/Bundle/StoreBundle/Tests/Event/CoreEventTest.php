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

use \Zepluf\Bundle\StoreBundle\Event\CoreEvent;

class CoreEventTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        $this->object = new CoreEvent();
    }

    public function testGetSet()
    {
        $content = "test content";

        $this->object->setContent($content);
        $this->assertEquals($content, $this->object->getContent());
    }

    public function tearDown()
    {
        unset($this->object);
    }
}