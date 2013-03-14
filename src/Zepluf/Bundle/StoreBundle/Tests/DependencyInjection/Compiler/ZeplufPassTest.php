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

namespace Zepluf\Bundle\StoreBundle\Tests\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Zepluf\Bundle\StoreBundle\DependencyInjection\Compiler\ZeplufPass;
use Symfony\Component\Yaml\Yaml;

class ZeplufPassTest extends \PHPUnit_Framework_TestCase
{
    public function testValid()
    {
        $trans_definition = $this->getMock('Symfony\Component\DependencyInjection\Definition');

        $trans_definition->expects($this->at(0))
            ->method('addMethodCall')
            ->with('addResource', array('yml', __DIR__ . '/../../Fixtures/appDir/plugins/riFoo/Resources/translations\messages.en.yml', 'en', 'messages'));

        $trans_definition->expects($this->at(1))
            ->method('addMethodCall')
            ->with('addResource', array('yml', __DIR__ . '/../../Fixtures/appDir/plugins/riFoo/Resources/translations\messages.fr.yml', 'fr', 'messages'));

        $trans_definition->expects($this->at(2))
            ->method('addMethodCall')
            ->with('addResource', array('yml', __DIR__ . '/../../Fixtures/appDir/plugins/riFooBar/Resources/translations\messages.en.yml', 'en', 'messages'));

        $trans_definition->expects($this->at(3))
            ->method('addMethodCall')
            ->with('addResource', array('yml', __DIR__ . '/../../Fixtures/appDir/plugins/riFooBar/Resources/translations\messages.fr.yml', 'fr', 'messages'));

        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder');
        $container->expects($this->once())
            ->method('hasParameter')
            ->will($this->returnValue(true));

        $container->expects($this->any())
            ->method('addResource');

        $container->expects($this->any())
            ->method('getParameter')
            ->with($this->logicalOr(
            $this->equalTo('sys'),
            $this->equalTo('kernel.root_dir')))
            ->will($this->returnCallback(array($this, 'myCallBack')));

        $container->expects($this->exactly(2))
            ->method('findDefinition')
            ->will($this->returnValue($trans_definition));

        $pass = new ZeplufPass();
        $pass->process($container);
    }

    public function myCallback($foo)
    {
        if ($foo === 'sys') {
            return Yaml::parse(__DIR__ . '/../Fixtures/sys.yml');
        } elseif ($foo === 'kernel.root_dir') {
            return __DIR__ . '/../../Fixtures/appDir';
        }
    }
}