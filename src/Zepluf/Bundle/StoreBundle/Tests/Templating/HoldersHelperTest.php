<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 10/16/12
 * Time: 6:55 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF framework
 */

namespace Zepluf\Bundle\StoreBundle\Tests\Templating;

use Zepluf\Bundle\StoreBundle\Tests\BaseTestCase;
use Zepluf\Bundle\StoreBundle\HoldersHelperEvents;
use Zepluf\Bundle\StoreBundle\Event\HoldersHelperEvent;

class HoldersHelperTest extends BaseTestCase
{
    protected $object;

    public function setUp()
    {
        $this->object = $this->get("templating.helper.holders");
    }

    public function testGetName()
    {
        $this->assertEquals('holders', $this->object->getName());
    }

    public function testAdd()
    {
        $t1_content1 = array('holder' => 'test1', 'content' => 'test1 ', 'order' => 2);
        $t1_content2 = array('holder' => 'test1', 'content' => 'test2 ', 'order' => 2);
        $t1_content3 = array('holder' => 'test1', 'content' => 'test3 ', 'order' => 2);
        $t1_content4 = array('holder' => 'test1', 'content' => 'test4 ');

        $this->object->add($t1_content1['holder'], $t1_content1['content'], $t1_content1['order']);
        $this->object->add($t1_content2['holder'], $t1_content2['content'], $t1_content2['order']);
        $this->object->add($t1_content3['holder'], $t1_content3['content'], $t1_content3['order']);
        $this->object->add($t1_content4['holder'], $t1_content4['content']);

        $this->assertEquals(trim($t1_content4['content'] . $t1_content3['content'] . $t1_content2['content'] . $t1_content1['content']), trim($this->object->get('test1')));
    }

    public function testGet()
    {
        $holder = 'test';
        $this->get('event_dispatcher')->addListener(HoldersHelperEvents::onHolderStart . '.' . $holder, array($this, 'onHolder1'));

        $content = $this->object->get($holder);
        $this->assertEquals(trim('priority content herecontent here'), trim($content));
    }

    public function testInjectHolders()
    {
        $holder1 = 'test';
        $holder2 = 'test2';
        $this->get('event_dispatcher')->addListener(HoldersHelperEvents::onHolderStart . '.' . $holder1, array($this, 'onHolder1'));
        $this->get('event_dispatcher')->addListener(HoldersHelperEvents::onHolderStart . '.' . $holder2, array($this, 'onHolder2'));

        $content =
            '<!-- holder:' . $holder1 . '-->' .
                '<div></div>' .
                '<!-- holder:' . $holder2 . '-->';

        $expect_content =
            'priority content here' .
                'content here' .
                '<!-- holder:' . $holder1 . '-->' .
                '<div></div>' .
                '<a href="http://www.w3schools.com">Visit W3Schools</a>.' .
                '<!-- holder:' . $holder2 . '-->';

        $output_content = $this->object->injectHolders($content);

        $this->assertEquals($expect_content, $output_content);

    }

    public function tearDown()
    {
        unset($this->object);
    }

    public function onHolder1(HoldersHelperEvent $event)
    {
        $this->get('templating.helper.holders')->add($event->getHolder(), 'content here', 2);
        $this->get('templating.helper.holders')->add($event->getHolder(), 'priority content here', 1);
    }

    public function onHolder2(HoldersHelperEvent $event)
    {
        $content = '<a href="http://www.w3schools.com">Visit W3Schools</a>.';
        $this->get('templating.helper.holders')->add($event->getHolder(), $content);
    }
}
