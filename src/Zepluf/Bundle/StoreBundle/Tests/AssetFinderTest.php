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

use Zepluf\Bundle\StoreBundle\AssetFinder;

class AssetFinderProdEnvTest extends \PHPUnit_Framework_TestCase
{
    protected $kernel;
    public $object;

    public function setUp()
    {
        $this->kernel = $this->getKernel();
        $this->object = new AssetFinder($this->kernel);
    }

    public function testFindAssets()
    {
        $paths = array();
        $paths[] = "http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js";
        $paths[] = "plugins:riFoo:css/foo_web.css";

        foreach ($paths as $path) {
            $files[$path] = null;
        }

        $list = $this->object->findAssets($files);

        //Assertion
        $this->assertArrayHasKey("http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js", $list);
        $this->assertArrayHasKey($this->kernel->getContainer()->getParameter('web.dir') . '/plugins/riFoo/css/foo_web.css', $list);

        $this->assertTrue($list[$paths[0]]['external']);
        $this->assertFalse($list[$this->kernel->getContainer()->getParameter('web.dir') . '/plugins/riFoo/css/foo_web.css']['external']);
    }

    public function testFindAssetInline()
    {
        $inlineScript = "
        $(document).ready(function(){
            $('p').click(function(){
                $(this).hide();
            });
        });";

        $options = array('inline' => true);
        $path = $this->object->findAsset($inlineScript, $options);

        $this->assertEquals($inlineScript, $path);
    }

    public function testFindAssetExternal()
    {
        $source = 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js';
        $path = $this->object->findAsset($source);
        $this->assertEquals($source, $path);

        $source = 'https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js';
        $path = $this->object->findAsset($source);
        $this->assertEquals($source, $path);

        $source = '//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js';
        $path = $this->object->findAsset($source);
        $this->assertEquals($source, $path);
    }

    public function testFindAssetPlugins()
    {
        $path = realpath($this->object->findAsset('plugins:riFoo:css/foo_web.css'));
        $expectation = realpath($this->kernel->getContainer()->getParameter('web.dir') . '/plugins/riFoo/css/foo_web.css');
        $this->assertEquals($expectation, $path);
    }

    public function testFindAssetTemplates()
    {
        $path = realpath($this->object->findAsset('templates:foobar:css/foo_web.css'));

        //frontend
        $expectation = realpath($this->kernel->getContainer()->getParameter('web.dir') . '/frontend/templates/foobar/css/foo_web.css');
        $this->assertEquals($expectation, $path);
    }

    public function testFindAssetImages()
    {
        $path = realpath($this->object->findAsset('images:no_picture.gif'));
        $expectation = realpath($this->kernel->getContainer()->getParameter('web.dir') . '/images/no_picture.gif');
        $this->assertEquals($expectation, $path);
    }

    public function testFindAssetMissingElement()
    {
        //plugin
        $path = realpath($this->object->findAsset('riFoo:css/foo_web.css'));
        $expectation = realpath($this->kernel->getContainer()->getParameter('web.dir') . '/plugins/riFoo/css/foo_web.css');
        $this->assertEquals($expectation, $path);

        //bundle
    }

    public function testSetSupportedExternals()
    {
        $supportExternals = array('a', 'b', 'c');
        $this->object->setSupportedExternals($supportExternals);
        $this->assertSame($supportExternals, \PHPUnit_Framework_Assert::readAttribute($this->object, 'supportedExternals'));
    }

    public function testGet()
    {
        $paths = array();
//        $paths[] = "http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js";
        $paths[] = 'plugins:riFoo:css/foo_web.css';
        $paths[] = 'images:no_picture.gif';

        foreach ($paths as $path) {
            $files[$path] = null;
        }

        $list = $this->object->get($files);

        $this->assertEquals('plugins/riFoo/css/foo_web.css', $list[0]['path']);
        $this->assertEquals('images/no_picture.gif', $list[1]['path']);
    }

    protected function getKernel()
    {
        $sc = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');

        $sc
            ->expects($this->any())
            ->method('get')
            ->with($this->logicalOr(
            $this->equalTo('environment'),
            $this->equalTo('utility.file')
        ))
            ->will($this->returnCallback(array($this, 'getCallBack')));

        $sc
            ->expects($this->any())
            ->method('getParameter')
            ->with($this->logicalOr(
            $this->equalTo('web.dir'),
            $this->equalTo('kernel.root_dir'),
            $this->equalTo('store.' . (new ProdEnvironment())->getSubEnvironment() . '.templates_dir')
        ))
            ->will($this->returnCallback(array($this, 'getParameterCallBack')));

        $kernel = $this->getMock('Symfony\Component\HttpKernel\KernelInterface');

        $kernel
            ->expects($this->any())
            ->method('getContainer')
            ->will($this->returnValue($sc));

        return $kernel;
    }

    public function getParameterCallBack($foo)
    {
        if ($foo === 'kernel.root_dir') {
            return __DIR__ . '/Fixtures/appDir';
        } elseif ($foo === 'web.dir') {
            return __DIR__ . '/Fixtures/webDir';
        } else {
            return __DIR__ . '/Fixtures/templates';
        }
    }

    public function getCallBack($foo)
    {
        if ($foo === 'environment') {
            return new ProdEnvironment();
        } else {
            return new \Zepluf\Bundle\StoreBundle\Utility\File($this->getMock('Zepluf\Bundle\StoreBundle\Utility\String'));
        }
    }
}

class AssetFinderDevEnvTest extends \PHPUnit_Framework_TestCase
{
    protected $kernel;
    protected $object;

    public function setUp()
    {
        $this->kernel = $this->getKernel();
        $this->object = new AssetFinder($this->kernel);
    }

    public function testFindAssets()
    {
        $paths = array();
        $paths[] = "http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js";
        $paths[] = "plugins:riFooBar:css/foo.css";
        $paths[] = "templates:foobar:css/foo.css";

        foreach ($paths as $path) {
            $files[$path] = null;
        }

        $list = $this->object->findAssets($files);

        //Assertion
        $this->assertArrayHasKey("http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js", $list);
        $this->assertArrayHasKey($this->kernel->getContainer()->getParameter('plugins.root_dir') . '/riFooBar/Resources/public/css/foo.css', $list);
        $this->assertArrayHasKey($this->kernel->getContainer()->getParameter('store.frontend.templates_dir') . '/foobar/css/foo.css', $list);

        $this->assertTrue($list[$paths[0]]['external']);
        $this->assertFalse($list[$this->kernel->getContainer()->getParameter('plugins.root_dir') . '/riFooBar/Resources/public/css/foo.css']['external']);
        $this->assertFalse($list[$this->kernel->getContainer()->getParameter('store.frontend.templates_dir') . '/foobar/css/foo.css']['external']);
    }

    public function testFindAssetPlugins()
    {
        $path = realpath($this->object->findAsset('plugins:riFooBar:css/foo.css'));
        $expectation = realpath($this->kernel->getContainer()->getParameter('plugins.root_dir') . '/riFooBar/Resources/public/css/foo.css');
        $this->assertEquals($expectation, $path);
    }

    public function testFindAssetTemplates()
    {
        $path = realpath($this->object->findAsset('templates:foobar:css/foofoo.css'));

        //frontend
        $expectation = realpath($this->kernel->getContainer()->getParameter('store.frontend.templates_dir') . '/foobar/css/foofoo.css');
        $this->assertEquals($expectation, $path);
    }

    public function testFindAssetMissingElement()
    {
        //plugin
        $path = realpath($this->object->findAsset('riFooBar:css/foo.css'));
        $expectation = realpath($this->kernel->getContainer()->getParameter('plugins.root_dir') . '/riFooBar/Resources/public/css/foo.css');
        $this->assertEquals($expectation, $path);

        //bundle
    }

    public function tearDown()
    {
        $this->object = null;
    }

    protected function getKernel()
    {
        $environment = new TestEnvironment();

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
            $this->equalTo('web.dir'),
            $this->equalTo('kernel.root_dir'),
            $this->equalTo('plugins.root_dir'),
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
            return __DIR__ . '/Fixtures/appDir';
        } elseif ($foo === 'web.dir') {
            return __DIR__ . '/Fixtures/webDir';
        } elseif ($foo == 'plugins.root_dir') {
            return __DIR__ . '/Fixtures/appDir/plugins';
        } else {
            return __DIR__ . '/Fixtures/appDir/templates';
        }
    }
}