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

use Zepluf\Bundle\StoreBundle\Utility\File;

class FileTest extends \Zepluf\Bundle\StoreBundle\Tests\BaseTestCase
{
    protected $object;

    public function testGetRelativePath()
    {
        $stringUtility = $this->getMock('Zepluf\Bundle\StoreBundle\Utility\String');
        $this->object = new File($stringUtility);

        $from = __DIR__;
        $to = __DIR__ . '/../Fixtures/Utility';
        $path = $this->object->getRelativePath($from, $to);
        $this->assertEquals('../Fixtures/Utility', $path);
    }

    public function testCalculatePath()
    {
        $stringUtility = $this->getMock('Zepluf\Bundle\StoreBundle\Utility\String');
        $stringUtility
            ->expects($this->once())
            ->method('stripNonAlphaNumeric')
            ->with($this->equalTo(strtolower('testname')))
            ->will($this->returnValue('testname'));

        $this->object = new File($stringUtility);

        $path = $this->object->calculatePath('testname', __DIR__ . '/', 4);
        $this->assertEquals(__DIR__ . '/t/e/s/t', $path);
    }

    public function testSureRemoveDir()
    {
        $stringUtility = $this->getMock('Zepluf\Bundle\StoreBundle\Utility\String');
        $this->object = new File($stringUtility);

        $dir = __DIR__ . '/../Fixtures/Utility/DirToRemove/';
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
        $stringUtility = $this->getMock('Zepluf\Bundle\StoreBundle\Utility\String');
        $this->object = new File($stringUtility);

        $dir = __DIR__ . '/../Fixtures/Utility/';
        $data = "Hello world";
        $this->object->write($dir . 'FileWrite', $data);

        $file_contents = file_get_contents($dir . "FileWrite");
        $this->assertEquals($file_contents, $data);
    }

    public function testXCopy()
    {
        $stringUtility = $this->getMock('Zepluf\Bundle\StoreBundle\Utility\String');
        $this->object = new File($stringUtility);

        $source = __DIR__ . '/../Fixtures/Utility/xcopySource';
        $dest = __DIR__ . '/../Fixtures/Utility/xcopyDest';

        $sourceHandle = opendir($source);
        $sourceArray = array();
        while (false !== ($entry = readdir($sourceHandle))) {
            $sourceArray[] = $entry;
        }

        $this->object->xcopy($source, $dest);

        $destHandle = opendir($dest);
        $destArray = array();
        while (false !== ($entry = readdir($destHandle))) {
            $destArray[] = $entry;
        }

        //Assertion: Compare two dirs
        $this->assertEquals($sourceArray, $destArray);

        //Clear junks
        $this->object->sureRemoveDir($dest, true);
    }

    public function tearDown()
    {
        unset($this->object);
    }
}
