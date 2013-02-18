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

use Zepluf\Bundle\StoreBundle\Templating\Loader\PluginLoader;
use Zepluf\Bundle\StoreBundle\Templating\TemplateReference;

class PluginLoaderTest extends \PHPUnit_Framework_TestCase
{
    protected $loader;

    protected $kernel;

    protected function setUp()
    {
        $this->kernel = $this->getKernel();
    }

    protected function tearDown()
    {
        $this->loader = null;
    }

    public function testLoadWithOverride()
    {
        $this->loader = new PluginLoader($this->kernel);
        $template = new TemplateReference('plugins', 'riFooBar', 'Bar', 'baz_override', 'format', 'engine');
        $file = $this->loader->load($template);

        $this->assertInstanceOf('Symfony\\Component\\Templating\\Storage\\FileStorage', $file);
        $this->assertEquals('templates/foobar/plugins/riFooBar/baz', $file->getContent());
    }

    public function testLoadWithoutOverride()
    {
        $this->loader = new PluginLoader($this->kernel);
        $template = new TemplateReference('plugins', 'riFooBar', 'Bar', 'baz', 'format', 'engine');
        $file = $this->loader->load($template);

        $this->assertInstanceOf('Symfony\\Component\\Templating\\Storage\\FileStorage', $file);
        $this->assertEquals('plugins/riFooBar/Resources/views/Bar/baz', $file->getContent());
    }

    protected function getTemplatePathPatterns()
    {
        return \PHPUnit_Framework_Assert::readAttribute($this->loader, 'templatePathPatterns');
    }

    protected function getKernel()
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
            ->with($this->logicalOr(
            $this->equalTo('kernel.root_dir'),
            $this->equalTo('store.' . $environment->getSubEnvironment() . '.templates_dir')
        ))
            ->will($this->returnCallback(array($this, 'myCallback')));


        $kernel = $this->getMock('Symfony\Component\HttpKernel\KernelInterface');

        $kernel
            ->expects($this->any())
            ->method('getContainer')
            ->will($this->returnValue($sc));

        return $kernel;
    }

    public function myCallback($foo)
    {
        if ($foo === 'kernel.root_dir') {
            return __DIR__ . '/../Fixtures/appDir';
        } else {
            return __DIR__ . '/../Fixtures/appDir/templates';
        }
    }
}