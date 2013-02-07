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

use Zepluf\Bundle\StoreBundle\Templating\Loader\BaseLoader;
use Zepluf\Bundle\StoreBundle\Templating\TemplateReference;

class BaseLoaderTest extends \PHPUnit_Framework_TestCase
{
    protected $loader;

    protected function setUp()
    {
        $kernel = $this->getKernel();
        $this->loader = new BaseLoader($kernel);
    }

    protected function tearDown()
    {
        $this->loader = null;
    }

    public function testLocate()
    {
        $templatePathPatterns = $this->getTemplatePathPatterns();

        $template = new TemplateReference('bundles', 'FooBundle', 'Bar', 'name', 'format', 'engine');

        $reflectionOfLoader = new \ReflectionClass('Zepluf\Bundle\StoreBundle\Templating\Loader\BaseLoader');
        $method = $reflectionOfLoader->getMethod('locate');
        $method->setAccessible(true);

        $file = $method->invokeArgs($this->loader, array($template, $templatePathPatterns));
    }

    private function getTemplatePathPatterns()
    {
        return \PHPUnit_Framework_Assert::readAttribute($this->loader, 'templatePathPatterns');
    }

    private function getKernel()
    {
        $environment = new Environment();

        $sc = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $sc
            ->expects($this->any())
            ->method('get')
            ->with($this->equalTo('environment'))
            ->will($this->returnValue($environment));
        $sc
            ->expects($this->any())
            ->method('getParameter')
            ->will($this->returnValue(__DIR__ . '/Fixtures/templates'));

        $kernel = $this->getMock('Symfony\Component\HttpKernel\KernelInterface');

        $kernel
            ->expects($this->any())
            ->method('getContainer')
            ->will($this->returnValue($sc));

        return $kernel;
    }
}

class Environment
{
    protected $subEnvironment = 'frontend';

    public function getTemplate()
    {
        return 'foobar';
    }

    public function getSubEnvironment()
    {
        return $this->subEnvironment;
    }

    public function setSubEnvironment($value)
    {
        $this->subEnvironment = $value;
    }
}

class ProdEnvironment extends Environment
{
    public function getEnvironment()
    {
        return 'prod';
    }
}

class TestEnvironment extends Environment
{
    public function getEnvironment()
    {
        return 'test';
    }
}