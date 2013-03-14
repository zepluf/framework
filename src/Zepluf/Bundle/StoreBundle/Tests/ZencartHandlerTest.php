<?php
/**
 * Created by RubikIntegration Team.
 *
 * User: Tuan Nguyen
 * Date: 1/9/13
 * Time: 2:12 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF framework
 */

namespace Zepluf\Bundle\StoreBundle\Tests;

use Monolog\Logger;
use Zepluf\Bundle\StoreBundle\Logger\Handler\ZencartHandler;

class ZencartHandlerTest extends BaseTestCase
{
    public $object;

    public function testAddBackEnd()
    {
        $environment = new Environment();
        $environment->setSubEnvironment('backend');
        $this->object = new ZencartHandler($environment);

        $add = self::getMethod('add');

        global $messageStack;
        $messageStack = $this->getMock('messageStack', array('add_session', 'add'));

        $record["context"]["class"] = 'messageStackError';
        $record['message'] = 'error message';
        $type = 'error';

        $this->get('environment')->setSubEnvironment('backend');
        //Case #1
        $record["context"]["session"] = true;

        $messageStack->expects($this->once())
            ->method('add_session')
            ->with('error message', 'error');

        $add->invokeArgs($this->object, array($record, $type));

        //Case #2
        $record["context"]["session"] = false;

        $messageStack->expects($this->once())
            ->method('add')
            ->with('error message', 'error');

        $add->invokeArgs($this->object, array($record, $type));
    }

    public function testAddFrontEnd()
    {
        $environment = new Environment();
        $environment->setSubEnvironment('frontend');
        $this->object = new ZencartHandler($environment);

        $add = self::getMethod('add');

        global $messageStack;
        $messageStack = $this->getMock('messageStack', array('add_session', 'add'));

        $record["context"]["class"] = 'messageStackError';
        $record['message'] = 'error message';
        $type = 'error';

        $this->get('environment')->setSubEnvironment('frontend');

        //Case #3
        $record["context"]["session"] = true;

        $messageStack->expects($this->once())
            ->method('add_session')
            ->with('messageStackError', 'error message', 'error');

        $add->invokeArgs($this->object, array($record, $type));

        //Case #4
        $record["context"]["session"] = false;

        $messageStack->expects($this->once())
            ->method('add')
            ->with('messageStackError', 'error message', 'error');

        $add->invokeArgs($this->object, array($record, $type));
    }

    public function testWriteBackEnd()
    {
        $environment = new Environment();
        $environment->setSubEnvironment('backend');
        $this->object = new ZencartHandler($environment);

        $write = self::getMethod('write');

        $this->get('environment')->setSubEnvironment('backend');

        global $messageStack;
        $messageStack = $this->getMock('messageStack', array('add_session', 'add'));

        $record["context"]["zencart"] = true;
        $record["context"]["session"] = true;
        $record["level"] = Logger::INFO;
        $record["context"]["class"] = 'messageStackSuccess';
        $record['message'] = 'success message';

        $messageStack->expects($this->once())
            ->method('add_session')
            ->with('success message', 'success');

        $write->invokeArgs($this->object, array($record));
    }

    public function testWriteFrontEnd()
    {
        $environment = new Environment();
        $environment->setSubEnvironment('frontend');
        $this->object = new ZencartHandler($environment);

        $write = self::getMethod('write');

        $this->get('environment')->setSubEnvironment('frontend');

        global $messageStack;
        $messageStack = $this->getMock('messageStack', array('add_session', 'add'));

        $record["context"]["zencart"] = true;
        $record["context"]["session"] = false;
        $record["level"] = Logger::INFO;
        $record["context"]["class"] = 'messageStackSuccess';
        $record['message'] = 'success message';

        $messageStack->expects($this->once())
            ->method('add')
            ->with('messageStackSuccess', 'success message', 'success');

        $write->invokeArgs($this->object, array($record));
    }

    public function tearDown()
    {
        unset($this->object);
    }

    protected static function getMethod($name)
    {
        $class = new \ReflectionClass('Zepluf\Bundle\StoreBundle\Logger\Handler\ZencartHandler');
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}