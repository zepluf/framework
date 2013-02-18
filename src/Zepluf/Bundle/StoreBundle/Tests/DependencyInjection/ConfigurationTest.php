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

namespace Zepluf\Bundle\StoreBundle\Tests\DependencyInjection;

use Zepluf\Bundle\StoreBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultConfig()
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(false), array(array('plugins' => array('one', 'two'))));

        $this->assertEquals(
            array_merge(array('plugins' => array('one', 'two')), self::getDefaultConfig()),
            $config
        );
    }

    protected static function getDefaultConfig()
    {
        return array(
            'plugins' => null
        );
    }

}