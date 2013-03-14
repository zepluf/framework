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

use Zepluf\Bundle\StoreBundle\Templating\Loader\BundleLoader;
use Zepluf\Bundle\StoreBundle\Templating\TemplateReference;

class BundleLoaderTest extends \PHPUnit_Framework_TestCase
{
    protected $loader;

    private $kernel;

    private $bundles = array();

    protected function setUp()
    {
        $this->bundles['FooBundle'] = $this->getBundle('FooBundle', 'Zepluf\Bundle\StoreBundle\Tests\Fixtures\Templating\Bundles\FooBundle');

        $this->kernel = $this->getKernel();
        $this->kernel
            ->expects($this->once())
            ->method('getBundle')
            ->with($this->equalTo('FooBundle'))
            ->will($this->returnValue($this->bundles['FooBundle']));

        $this->loader = new BundleLoader($this->kernel);
    }

    protected function tearDown()
    {
        $this->loader = null;
    }

    public function testLoadWithOverride()
    {
        $template = new TemplateReference('bundles', 'FooBundle', 'Bar', 'qux_override', 'format', 'engine');

        $file = $this->loader->load($template);

        $this->assertInstanceOf('Symfony\\Component\\Templating\\Storage\\FileStorage', $file);
        $this->assertEquals('templates/foobar/bundles/FooBundle/Bar/qux_override', $file->getContent());
    }

    public function testLoadWithController()
    {
        $template = new TemplateReference('bundles', 'FooBundle', 'Bar', 'baz', 'format', 'engine');

        $file = $this->loader->load($template);

        $this->assertInstanceOf('Symfony\\Component\\Templating\\Storage\\FileStorage', $file);
        $this->assertEquals('Bundles/FooBundles/Resources/views/Bar/baz', $file->getContent());
    }

    public function testLoadWithoutController()
    {
        $template = new TemplateReference('bundles', 'FooBundle', '', 'qux', 'format', 'engine');

        $file = $this->loader->load($template);

        $this->assertInstanceOf('Symfony\\Component\\Templating\\Storage\\FileStorage', $file);
        $this->assertEquals('Bundles/FooBundles/Resources/views/qux', $file->getContent());
    }

    private function getTemplatePathPatterns()
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
            ->will($this->returnValue(__DIR__ . '/../Fixtures/appDir/templates'));

        $kernel = $this->getMock('Symfony\Component\HttpKernel\KernelInterface');

        $kernel
            ->expects($this->any())
            ->method('getContainer')
            ->will($this->returnValue($sc));

        return $kernel;
    }

    protected function getBundle($name, $namespace, $dir = null, $parent = null)
    {
        $bundle = $this->getMock('Symfony\Component\HttpKernel\Bundle\BundleInterface');
        $bundle
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue($name));

        $bundle
            ->expects($this->any())
            ->method('getNamespace')
            ->will($this->returnValue($namespace));

        $bundle
            ->expects($this->any())
            ->method('getParent')
            ->will($this->returnValue($parent));

        $bundle
            ->expects($this->any())
            ->method('getPath')
            ->will(!is_null($dir) ? $this->returnValue($dir) : $this->returnValue(__DIR__ . '/../Fixtures/Bundles/' . $name));

        return $bundle;
    }
}