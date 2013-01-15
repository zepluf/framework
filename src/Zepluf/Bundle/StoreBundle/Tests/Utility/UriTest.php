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

namespace Zepluf\Bundle\StoreBundle\Tests\Utility;

class UriTest extends \Zepluf\Bundle\StoreBundle\Tests\BaseTestCase
{
    protected $object;

    public function setUp()
    {
        $this->object = $this->get('utility.uri');
    }

    public function testGetCurrent()
    {
        $this->assertEquals(1, 1);
    }

    public function tearDown()
    {
        unset($this->object);
    }
}
