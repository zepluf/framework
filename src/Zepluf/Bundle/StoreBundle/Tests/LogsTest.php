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

use Zepluf\Bundle\StoreBundle\Logs;
use Monolog\Logger;

class LogsTest extends BaseTestCase
{
    protected $object;

    public function setUp()
    {
        $logger = $this->getMock('Logger', array('addRecord'));
        $environment = $this->get("environment");
        $environment->setSubEnvironment("frontend");
//        $this->object = $this->get('logs');
        $this->object = new Logs($logger, $environment);
    }

    public function testCopyFromZen()
    {
        $this->object->clear();
        global $messageStack;
        //replace global var $messageStack by new object TestMessageStack
        $messageStack = new TestMessageStack();

        //set value for $messageStack->messages
        $messageStack->messages[] = array('class' => 'messageStackError', 'text' => 'test error');
        $messageStack->messages[] = array('class' => 'messageStackWarning', 'text' => 'test warning');
        $messageStack->messages[] = array('class' => 'messageStackCaution', 'text' => 'test caution');

        //run actual method
        $this->object->copyFromZen();
        //get logs property
        $logs = $this->object->getLogs();

        $this->assertEquals($logs[0]['type'], Logger::ERROR);
        $this->assertEquals($logs[0]['message'], 'test error');

        $this->assertEquals($logs[1]['type'], Logger::WARNING);
        $this->assertEquals($logs[1]['message'], 'test warning');

        $this->assertEquals($logs[2]['type'], Logger::NOTICE);
        $this->assertEquals($logs[2]['message'], 'test caution');
    }

    public function testGetZenMessageType()
    {
        $class = 'messageStackWarning';
        $expected = Logger::WARNING;
        $this->assertEquals($this->object->getZenMessageType($class), $expected);

        $class = 'messageStackSuccess';
        $expected = Logger::INFO;
        $this->assertEquals($this->object->getZenMessageType($class), $expected);

        $class = 'messageStackCaution';
        $expected = Logger::NOTICE;
        $this->assertEquals($this->object->getZenMessageType($class), $expected);

        $class = 'messageStackError';
        $expected = Logger::ERROR;
        $this->assertEquals($this->object->getZenMessageType($class), $expected);
    }

    public function testClear()
    {
        $this->object->clear();
        $this->assertEquals(0, sizeof($this->object->getLogs()));
    }
}

class TestMessageStack
{
    public $messages;

    function __constructor()
    {
        $this->messages = array();
    }
}
