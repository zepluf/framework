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

use Zepluf\Bundle\StoreBundle\Templating\TemplateNameParser;
use Zepluf\Bundle\StoreBundle\Templating\TemplateReference;

class TemplateNameParserTest extends \PHPUnit_Framework_TestCase
{
    protected $parser;

    protected function setUp()
    {
        $kernel = $this->getMock('Symfony\Component\HttpKernel\KernelInterface');

        $this->parser = new TemplateNameParser($kernel);
    }

    protected function tearDown()
    {
        $this->parser = null;
    }

    /**
     * @dataProvider getLogicalNameToTemplateProvider
     */
    public function testParse($name, $ref, $logical)
    {
        $template = $this->parser->parse($name);

        $this->assertEquals($template->getLogicalName(), $ref->getLogicalName());

        $this->assertEquals($logical, $template->getLogicalName());
    }

    public function getLogicalNameToTemplateProvider()
    {
        return array(
            //bundles
            array('bundles:FooBundle:Post/index.html.php', new TemplateReference('bundles', 'FooBundle', 'Post', 'index', 'html', 'php'), 'bundles:FooBundle:Post/index.html.php'),
            array('bundles:FooBundle:index.html.php', new TemplateReference('bundles', 'FooBundle', '', 'index', 'html', 'php'), 'bundles:FooBundle:index.html.php'),
            array('FooBundle:Post:index.html.php', new TemplateReference('bundles', 'FooBundle', 'Post', 'index', 'html', 'php'), 'bundles:FooBundle:Post/index.html.php'),
            array('FooBundle:Post:index.html.twig', new TemplateReference('bundles', 'FooBundle', 'Post', 'index', 'html', 'twig'), 'bundles:FooBundle:Post/index.html.twig'),
            array('FooBundle:Post:index.xml.php', new TemplateReference('bundles', 'FooBundle', 'Post', 'index', 'xml', 'php'), 'bundles:FooBundle:Post/index.xml.php'),
            array('FooBundle::index.html.php', new TemplateReference('bundles', 'FooBundle', '', 'index', 'html', 'php'), 'bundles:FooBundle:index.html.php'),
            array('FooBundle:index.html.php', new TemplateReference('bundles', 'FooBundle', '', 'index', 'html', 'php'), 'bundles:FooBundle:index.html.php'),
            //plugins
            array('plugins:riFoo:Post/index.html.php', new TemplateReference('plugins', 'riFoo', 'Post', 'index', 'html', 'php'), 'plugins:riFoo:Post/index.html.php'),
            array('riFoo:Post/index.html.php', new TemplateReference('plugins', 'riFoo', 'Post', 'index', 'html', 'php'), 'plugins:riFoo:Post/index.html.php'),
            array('riFoo:index.html.php', new TemplateReference('plugins', 'riFoo', '', 'index', 'html', 'php'), 'plugins:riFoo:index.html.php'),
            //templates
            array('templates:classic:foobar.html.php', new TemplateReference('templates', 'classic', '', 'foobar', 'html', 'php'), 'templates:classic:foobar.html.php'),
            array('foobar.html.php', new TemplateReference('templates', 'current', '', 'foobar', 'html', 'php'), 'templates:current:foobar.html.php'),
            array('path/foobar.html.php', new TemplateReference('templates', 'current', 'path', 'foobar', 'html', 'php'), 'templates:current:path/foobar.html.php'),
        );
    }
}