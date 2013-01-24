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

use \Zepluf\Bundle\StoreBundle\Utility\File;

class FileTest extends \Zepluf\Bundle\StoreBundle\Tests\BaseTestCase
{
    protected $object;

//    public static function setUpBeforeClass()
//    {
//        define('DIR_WS_HTTPS_ADMIN', self::getParameter('store.zencart_dir') . '/expadmin');
//        define('DIR_WS_ADMIN', self::getParameter('store.zencart_dir') . '/expadmin');
//        define('DIR_WS_HTTPS_CATALOG', self::getParameter('store.zencart_dir'));
//        define('DIR_WS_CATALOG', self::getParameter('store.zencart_dir'));
//    }

    public function setUp()
    {
        $this->object = $this->get('utility.file');
    }

    public function testGetRelativePath()
    {
        $path = $this->object->getRelativePath($this->getParameter('kernel.root_dir'), $this->getParameter('store.zencart_dir'));
        $this->assertEquals('../..', $path);

        $path = $this->object->getRelativePath($this->getParameter('kernel.config_dir'), $this->getParameter('web.dir'));
        $this->assertEquals('../web', $path);
    }

    public function testGenerateUniqueName()
    {
        $name = ($this->object->generateUniqueName(__DIR__ . '/', 'StringTest.php'));
        $this->assertTrue(!file_exists(__DIR__ . '/' . $name));
    }

    public function testCalculatePath()
    {
        $path = $this->object->calculatePath('testname', __DIR__ . '/', 4);
        $this->assertEquals(__DIR__ . '/t/e/s/t', $path);
    }

    public function testUploadFile()
    {

    }

    public function testSureRemoveDir()
    {
        $dir = __DIR__ . '/../Fixtures/junks/utility/DirToRemove/';
        if (!file_exists($dir)) {
            mkdir($dir);
        }
        $fileHandle = fopen($dir . 'testFile.txt', 'w') or die("can't open file");

        $stringData = "Bobby Bopper\n";
        fwrite($fileHandle, $stringData);
        $stringData = "Tracy Tanner\n";
        fwrite($fileHandle, $stringData);

        fclose($fileHandle);

        $this->assertTrue(file_exists($dir) && is_dir($dir));

        $this->object->sureRemoveDir($dir, true);
        $this->assertTrue(!file_exists($dir));
    }

    public function testWrite()
    {
        $dir = __DIR__ . '/../Fixtures/junks/utility/';
        $data = "Hello world";
        $this->object->write($dir . "test", $data);

        $file_contents = file_get_contents($dir . "test");
        $this->assertEquals($file_contents, $data);
    }

    public function testGetCatalogToAdminRelativePath()
    {
    }

    public function testXCopy()
    {
        $sourceHandle = opendir(__DIR__ . '/../Fixtures/junks/plugins');
        $source = array();
        while (false !== ($entry = readdir($sourceHandle))) {
            $source[] = $entry;
        }

        $this->object->xcopy(__DIR__ . '/../Fixtures/junks/plugins', __DIR__ . '/../Fixtures/junks/utility/xcopy');

        $destinationHandle = opendir(__DIR__ . '/../Fixtures/junks/utility/xcopy');
        $destination = array();
        while (false !== ($entry = readdir($destinationHandle))) {
            $destination[] = $entry;
        }

        //Assertion: Compare two dirs
        $this->assertEquals($source, $destination);

        //Clear junks
        $this->object->sureRemoveDir(__DIR__ . '/../Fixtures/junks/utility/xcopy', true);
    }

    public function tearDown()
    {
        unset($this->object);
    }
}
