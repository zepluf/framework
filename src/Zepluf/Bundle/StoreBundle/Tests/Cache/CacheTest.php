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

use Zepluf\Bundle\StoreBundle\Cache\Cache;

class CacheTest extends BaseTestCase
{
    public $object;

    public function setUp()
    {
        $utilityFile = $this->getMock('Zepluf\Bundle\StoreBundle\Utility\File', array('sureRemoveDir'), array($this->getMock('Zepluf\Bundle\StoreBundle\Utility\String')));
        $this->object = new Cache(true, $utilityFile, $this->getParameter('kernel.cache_dir'));
    }

    public function testWrite()
    {
        $content = 'Cache content here';
        $this->object->write($this->getParameter('kernel.cache_dir') . '/cache', $content);
        $this->assertStringEqualsFile($this->getParameter('kernel.cache_dir') . "/cache", $content);
    }

    public function testRead()
    {
        $content = file_get_contents($this->getParameter('kernel.cache_dir') . "/cache");
        $file = $this->object->read($this->getParameter('kernel.cache_dir') . '/cache');
        $this->assertEquals($content, $file);
    }

    public function testWriteSubFolder()
    {
        $content = 'Cache content here';
        $this->object->write($this->getParameter('kernel.cache_dir') . '/abcdefghijklmnop', $content, true);
        $this->assertStringEqualsFile($this->getParameter('kernel.cache_dir') . "/a/b/c/d/abcdefghijklmnop", $content);
    }

    public function testReadSubFolder()
    {
        $content = file_get_contents($this->getParameter('kernel.cache_dir') . "/a/b/c/d/abcdefghijklmnop");
        $file = $this->object->read($this->getParameter('kernel.cache_dir') . '/abcdefghijklmnop', 0, true);
        $this->assertEquals($content, $file);
    }

//    public function testRemoveFile()
//    {
//        file_put_contents($this->getParameter('kernel.cache_dir') . "/test", 'file to remove');
//        $this->assertFileExists($this->getParameter('kernel.cache_dir') . "/test");
//        $this->object->remove('test', $this->getParameter('kernel.cache_dir'));
////        $this->assertFileNotExists($this->getParameter('kernel.cache_dir') . "/test");
//    }

    public function testRemoveFolder()
    {
        mkdir($this->getParameter('kernel.cache_dir') . "/rm");
        $this->assertFileExists($this->getParameter('kernel.cache_dir') . "/rm");
        $this->object->remove("", $this->getParameter('kernel.cache_dir') . "/rm", true);
        $this->assertFileExists($this->getParameter('kernel.cache_dir') . "/rm");
    }
}