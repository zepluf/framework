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

use Zepluf\Bundle\StoreBundle\Templating\TemplateReference;

class TemplateReferenceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getPathProvider
     */
    public function testGetPathWorksWithNamespacedControllers($expect, $reference)
    {
        $this->assertSame(
            $expect,
            $reference->getPath()
        );
    }

    public function getPathProvider()
    {
        return array(
            array('@FooBundle/Resources/views/bar/index.html.php', new TemplateReference('bundles', 'FooBundle', 'bar', 'index', 'html', 'php')),
            array('@FooBundle/Resources/views/index.html.php', new TemplateReference('bundles', 'FooBundle', '', 'index', 'html', 'php')),
        );
    }

    /**
     * @dataProvider getLogicalNameProvider
     */
    public function testGetLogicalName($expect, $reference)
    {
        $this->assertSame($expect, $reference->getLogicalName());
    }

    public function getLogicalNameProvider()
    {
        return array(
            array('bundles:FooBundle:bar/index.html.php', new TemplateReference('bundles', 'FooBundle', 'bar', 'index', 'html', 'php')),
            array('bundles:FooBundle:index.html.php', new TemplateReference('bundles', 'FooBundle', '', 'index', 'html', 'php')),
        );
    }


}