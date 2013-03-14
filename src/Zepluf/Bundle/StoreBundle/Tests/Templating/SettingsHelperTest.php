<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 10/16/12
 * Time: 6:55 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF framework
 */

namespace Zepluf\Bundle\StoreBundle\Tests\Templating;

use Zepluf\Bundle\StoreBundle\Tests\BaseTestCase;
use Zepluf\Bundle\StoreBundle\Templating\Helper\SettingsHelper;

class SettingsHelperTest extends BaseTestCase
{
    protected $object;

    public function testGet()
    {
        $settings = $this->getMock('Zepluf\Bundle\StoreBundle', array('get'));
        $settings->expects($this->once())
            ->method('get');
        $this->object = new SettingsHelper($settings);
        $this->object->get('sys');
    }

    public function testSet()
    {
        $settings = $this->getMock('Zepluf\Bundle\StoreBundle', array('has'));
        $settings->expects($this->once())
            ->method('has');
        $this->object = new SettingsHelper($settings);
        $this->object->has('sys');
    }
}